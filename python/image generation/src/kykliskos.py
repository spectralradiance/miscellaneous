import numpy
import math
import sys
import kmath
import datetime

from color import *
from shapes import *
from PIL import Image, ImageDraw
from kimage import *



# def draw_stars():
#     width = 1920
#     height = 1080
#     pimg = PixelImage(width, height, 5)
#     palette = Palette.create_from_color_ramp(RGBColor(1,1,180.0/255),RGBColor(1,1,1),5)
#     palette.colors.append(RGBColor(0,0,0))
#
#     for k in range(0, 1000):
#         star_size = int(1+numpy.random.exponential(0.3)*10)
#         star_color = numpy.random.randint(1,4)
#         star = PixelImage(star_size, star_size, star_color)
#         i = numpy.random.randint(0, pimg.width-1)
#         #j = numpy.random.randint(0, pimg.height-1)
#         j = (height/2)+int(numpy.random.exponential(0.2)*(height/2))*kmath.random_sign()
#         trn = Translate(i, j)
#         pimg.draw(star, trn)
#
#     render_and_show(pimg, palette)



if __name__ == '__main__':

    #seed = 0
    #if len(sys.argv) > 1:
    #    seed = int(sys.argv[1])
    seed = 1
    numpy.random.seed(seed)

    bb = blackbody_spd(10000)
    print(bb(400.0))

    bb2 = blackbody_spd(1000)
    print(bb2(400.0))

    print(bb(400.0))

    # name = datetime.datetime.now().strftime("%Y%m%d%H%M-%f")
    #img.save(name+".bmp", "bmp")


