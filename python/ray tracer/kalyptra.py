
# ┬┌─┌─┐┬ ┬ ┬┌─┐┌┬┐┬─┐┌─┐
# ├┴┐├─┤│ └┬┘├─┘ │ ├┬┘├─┤
# ┴ ┴┴ ┴┴─┘┴ ┴   ┴ ┴└─┴ ┴

import geometry3
from camera import Camera
from intersectable import Sphere
from scene import Scene

import kmath

def trace_ray(scene, rw):
    it = scene.find_intersection(rw)
    if it is None:
        return [0.0, 0.0, 0.0]
    return [1.0, 1.0, 1.0]

camera = Camera(1.0)
sphere = Sphere(1.0)
scene = Scene()
scene.intersectables.append(sphere)

from PIL import Image

img_width = 500
img_height = 500

img = Image.new('RGB', (img_width, img_height), (0, 0, 0))
pixels = img.load()
for i in range(img_width):
    for j in range(img_height):
        rw = camera.generate_ray(i, j, img_width, img_height)
        color = trace_ray(scene, rw)
        r = int(kmath.clamp(color[0])*255)
        g = int(kmath.clamp(color[1])*255)
        b = int(kmath.clamp(color[2])*255)
        pixels[i,j] = (r, g, b)


import time
current_time_millis = lambda: int(round(time.time() * 1000))


img.save('./renders/'+str(current_time_millis())+'.bmp')
img.show()
