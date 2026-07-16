import math
import numpy


def random_sign():
    return -1 if numpy.random.randint(0,2) == 0 else 1  # this is an abomination

def lerp(v0, v1, t):
    return (1 - t)*v0 + t*v1


def clamp(c):
    return 0 if (c < 0) else (1 if (c > 1) else c)


def gamma_encode(c: float):
    if c <= 0.0031308:
        return 12.92*c
    return 1.055*math.pow(c, 1/2.4) - 0.055


def gamma_decode(c: float):
    if c <= 0.04045:
        return c/12.92
    return math.pow((c+0.055)/1.055, 2.4)


def polar_to_rectangular(radius, angle):
    return Point(radius*numpy.cos(angle), radius*numpy.sin(angle))

class Point:
    def __init__(self, x: float, y: float):
        self.X = x
        self.Y = y


class Translate:

    def __init__(self, tx: float, ty: float):
        self.Tx = tx
        self.Ty = ty

    def transform(self, p: Point):
        return Point(self.Tx+p.X, self.Ty+p.Y)


class Rotate:

    def __init__(self, angle: float):
        self.angle = angle
        self.cos_angle = math.cos(angle)
        self.sin_angle = math.sin(angle)

    def transform(self, p: Point):
        return Point(p.X*self.cos_angle - p.Y*self.sin_angle,
                      p.X*self.sin_angle + p.Y*self.cos_angle)


class Scale:

    def __init__(self, sx: float, sy: float):
        self.Sx = sx
        self.Sy = sy

    def transform(self, p):
        return Point(p.X*self.Sx, p.Y*self.Sy)


