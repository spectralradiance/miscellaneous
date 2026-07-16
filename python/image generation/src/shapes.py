import numpy
import kmath
import kimage
from PIL import Image, ImageDraw


class BlackSun():

    def __init__(self, seed, source, n_sectors, center, maximum_radius):
        self.seed = seed
        self.source = source
        self.n_sectors = n_sectors
        self.center = center
        self.maximum_radius = maximum_radius
        self.rotator = kmath.Rotate(2*numpy.pi/n_sectors)

    def get_image(self):
        numpy.random.seed(self.seed)
        img = self.source.get_image()
        draw = ImageDraw.Draw(img)
        for radius in range(0, self.maximum_radius):
            angle = numpy.random.uniform(0, 2*numpy.pi)
            p = kmath.polar_to_rectangular(radius, angle)
            q = kmath.polar_to_rectangular(radius+6, angle)
            c = (0, 0, 0, 255) if (numpy.random.uniform(0,1) < 1) else (255,255,255,255)
            if radius/self.maximum_radius > 0.05:
                c0 = int(numpy.random.normal(20+radius/self.maximum_radius*255))
                if c0 > 255:
                    c0 = 255
                c = (c0, c0, c0, c0)

            if numpy.random.uniform(0.2,1) < radius/self.maximum_radius:
                continue

            for i in range(0, self.n_sectors):
                pr = (int(p.X+self.center.X), int(p.Y+self.center.Y))
                qr = (int(q.X+self.center.X), int(q.Y+self.center.Y))
                # kimage.set_pixel(img, pr, c)
                draw.line((pr[0], pr[1], qr[0], qr[1]), fill=c)
                p = self.rotator.transform(p)
                q = self.rotator.transform(q)

        draw.text((26,14), "Kykliskos", fill=(0,0,0,255))
        draw.rectangle((0,0,img.width-1,img.height-1),outline=(0,0,0,255))

        del draw
        return img



class MidpointDisplacement():

    def __init__(self, node, y_center, initial_displacement, displacement_scale_step, color, seed):
        self.node = node
        self.y_center = y_center
        self.initial_displacement = initial_displacement
        self.displacement_scale_step = displacement_scale_step
        self.color = color
        self.seed = seed

    def get_image(self):
        numpy.random.seed(self.seed)
        img = self.node.get_image()
        w = img.width
        h = img.height
        y = [0]*w
        y[0] = self.y_center + numpy.random.uniform(-self.initial_displacement/2, self.initial_displacement/2)
        y[w-1] = self.y_center + numpy.random.uniform(-self.initial_displacement/2, self.initial_displacement/2)
        self.midpoint_displacement_recurse(y, 0, w-1, self.initial_displacement*self.displacement_scale_step)
        draw = ImageDraw.Draw(img)
        for i in range(0, w):
            draw.line((i, int(y[i]), i, h), fill=self.color)
        del draw
        return img

    def midpoint_displacement_recurse(self, y, xmin, xmax, displacement):
        if xmin >= xmax or xmax == xmin+1:
            return
        if (xmax-xmin) < 5:
            for i in range(xmin, xmax):
                t = (i-xmin)/(xmax-xmin)
                y[i]= kmath.lerp(y[xmin],y[xmax],t)
            return

        xmid = int((xmax+xmin)/2)
        y[xmid] = (y[xmin]+y[xmax])/2
        y[xmid] += numpy.random.uniform(-displacement/2, displacement/2)
        displacement *= self.displacement_scale_step
        self.midpoint_displacement_recurse(y, xmin, xmid, displacement)
        self.midpoint_displacement_recurse(y, xmid, xmax, displacement)











