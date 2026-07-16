import numpy
import kmath
from PIL import Image


class KImage:

    def __init__(self, width, height, color):
        self.width = width
        self.height = height
        self.color = color







def luminance(c):
    return 0.2126*c[0] + 0.7152*c[1] + 0.0722*c[2]

def to_continuous(c):
    r = int(kmath.clamp(c[0])*255)
    g = int(kmath.clamp(c[1])*255)
    b = int(kmath.clamp(c[2])*255)
    a = int(kmath.clamp(c[3])*255)
    return [r, g, b, a]

def to_discrete(c):
    r = c[0]/255.0
    g = c[1]/255.0
    b = c[2]/255.0
    a = c[3]/255.0
    return [r, g, b, a]


def blend_mode_difference(a, b):
    if luminance(b) > luminance(a):
       a, b = b, a
    r = [0.0, 0.0, 0.0, 0.0]
    r[0] = kmath.clamp(a[0]-b[0])
    r[1] = kmath.clamp(a[1]-b[1])
    r[2] = kmath.clamp(a[2]-b[2])
    r[3] = kmath.clamp(a[3]-b[3])
    return r


def blend_mode_lighten(a, b):
    r = [0.0, 0.0, 0.0, 0.0]
    r[0] = a[0] if (a[0] > b[0]) else b[0]
    r[1] = a[1] if (a[1] > b[1]) else b[1]
    r[2] = a[2] if (a[2] > b[2]) else b[2]
    r[3] = int((a[3] + b[3]) / 2) #average the alpha channel
    return r

def blend_mode_darken(a, b):
    r = [0.0, 0.0, 0.0, 0.0]
    r[0] = a[0] if (a[0] < b[0]) else b[0]
    r[1] = a[1] if (a[1] < b[1]) else b[1]
    r[2] = a[2] if (a[2] < b[2]) else b[2]
    r[3] = int((a[3]+b[3])/2)
    return r

def set_pixel(img, p, c):
    if 0 <= p[0] < img.width and 0 <= p[1] < img.height:
        img.putpixel(p, c)

class ImageReader():
    def __init__(self, path):
        self.path = path
    def get_image(self):
        return Image.open(self.path)


class ImageCreator():
    def __init__(self, width, height, color=(0,0,0,0)):
        self.width = width
        self.height = height
        self.color = color

    def get_image(self):
        return Image.new('RGBA', (self.width, self.height), self.color)


class ImageLayer():
    def __init__(self, px, py, opacity, blend_mode):
        self.px = px
        self.py = py
        self.opacity = opacity
        self.blend_mode = blend_mode


class ImageLayers():
    def __init__(self, layers=[]):
        self.layers = layers

    def get_image(self):
        r = self.layers[0].get_image()
        for i in range(1, len(self.layers)):
            r = Image.alpha_composite(r, self.layers[i].get_image())
        return r


def merge_images(img_a, img_b):
    pix_a = img_a.load()
    pix_b = img_b.load()
    for i in range(0, pix_b.width):
        pix_a = img_a.load();




class GreyscaleTransform():
    def __init__(self, node):
        self.node = node

    def get_image(self):
        img = self.node.get_image()
        return img.convert('L')


class ImageScale():

    def __init__(self, node, sx, sy):
        self.node = node
        self.sx = sx
        self.sy = sy

    def get_image(self):
        img = self.node.get_image()
        return img.resize((img.width*self.sx, img.height*self.sy))

