import colorsys
import random
import math
import kmath


class KColor:

    def __init__(self, red, green, blue, alpha):
        self.red = red
        self.green = green
        self.blue = blue
        self.alpha = alpha

    def normalize(self):
        m = max(self.red, self.green, self.blue)
        self.red /= m
        self.green /= m
        self.blue /= m

    def to_hsv(self):
        return colorsys.rgb_to_hsv(self.red, self.green, self.blue)




def hsv_to_rgba(hsv):
    rgb = colorsys.hsv_to_rgb(hsv[0], hsv[1], hsv[2])
    return [rgb[0], rgb[1], rgb[2], 1.0]


def rgba_to_hsv(c):
    pass


def lerp_rgba(ca, cb, n_steps):
    r = []
    scale = 1/(n_steps-1)
    for i in range(0, n_steps):
        t = i*scale
        c = [0.0, 0.0, 0.0, 0.0]
        c[0] = kmath.lerp(ca[0], cb[0], t)
        c[1] = kmath.lerp(ca[1], cb[1], t)
        c[2] = kmath.lerp(ca[2], cb[2], t)
        c[3] = kmath.lerp(ca[3], cb[3], t)
    return r


def blackbody_spd(temperature):
    def evaluate(wl: float):
        wlm = wl * 1.0E-9
        wl5m = wlm * wlm
        wl5m *= wl5m
        wl5m *= wlm
        two_hcc2 = 1.19104259E-16
        hcok = 0.0143877506
        ef = hcok / (wlm * temperature)
        return two_hcc2 / (wl5m * (math.exp(ef) - 1.0))
    return evaluate


# http://jcgt.org/published/0002/02/01/
def xyz_for_wavelength(wl):
    x1 = (wl-442.0)*(0.0624 if (wl < 442.0) else 0.0374)
    x2 = (wl-599.8)*(0.0264 if (wl < 599.8) else 0.0323)
    x3 = (wl-501.1)*(0.0490 if (wl < 501.1) else 0.0382)
    x = 0.362*math.exp(-0.5*x1*x1) + 1.056*math.exp(-0.5*x2*x2) - 0.065*math.exp(-0.5*x3*x3)

    y1 = (wl-568.8)*(0.0213 if (wl < 568.8) else 0.0247)
    y2 = (wl-530.9)*(0.0613 if (wl < 530.9) else 0.0322)
    y = 0.821*math.exp(-0.5*y1*y1) + 0.286*math.exp(-0.5*y2*y2)

    z1 = (wl-437.0)*(0.0845 if (wl < 437.0) else 0.0278)
    z2 = (wl-459.0)*(0.0385 if (wl < 459.0) else 0.0725)
    z = 1.217*math.exp(-0.5*z1*z1) + 0.681*math.exp(-0.5*z2*z2)

    return [x, y, z]




# sRGB color space
def xyz_to_rgba(c):
    r = c[0]*3.240479 + c[1]*-1.537150 + c[2]*-0.498535
    g = c[0]*-0.969256 + c[1]*1.875991 + c[2]*0.041556
    b = c[0]*0.055648 + c[1]*-0.204043 + c[2]*1.057311
    return [r, g, b, 1.0]

def rgba_to_xyz(c):
    x = c[0]*0.412453 + c[1]*0.357580 + c[2]*0.180423
    y = c[0]*0.212671 + c[1]*0.715160 + c[2]*0.072169
    z = c[0]*0.019334 + c[1]*0.119193 + c[2]*0.950227
    return [x, y, z]

def SPDtoRGB(spd: SPD):
    xyz = XYZColor(0,0,0)
    for wl in range(400,700):
        xyz += spd.evaluate(wl)*XYZColor.for_wavelength(wl)
    rgb = XYZtoRGB(xyz)
    return rgb



