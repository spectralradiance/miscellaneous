
# ┬┌─┌─┐┬ ┬ ┬┌─┐┌┬┐┬─┐┌─┐
# ├┴┐├─┤│ └┬┘├─┘ │ ├┬┘├─┤
# ┴ ┴┴ ┴┴─┘┴ ┴   ┴ ┴└─┴ ┴

import math


def clamp(a):
    return 0 if a < 0 else (1 if a > 1 else a)


def sign(a):
    return 1 if a > 0 else -1


def quadratic(a, b, c):
    t = b*b - 4.0*a*c
    if t < 0.0:
        return []
    if t < 1E-3:
        if a == 0:
            return [0]
        return [-b/(2*a)]
    t = 2.0*math.sqrt(t)
    if b < 0.0:
        t = -0.5*(b-t)
    else:
        t = -0.5*(b+t)
    r0 = t/a
    r1 = c/t
    if r0 < r1:
        return [r0, r1]
    return [r1, r0]

