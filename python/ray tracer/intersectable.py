
# ┬┌─┌─┐┬ ┬ ┬┌─┐┌┬┐┬─┐┌─┐
# ├┴┐├─┤│ └┬┘├─┘ │ ├┬┘├─┤
# ┴ ┴┴ ┴┴─┘┴ ┴   ┴ ┴└─┴ ┴

import kmath
from geometry3 import Triplet


class Intersection:
    def __init__(self, ro, t, e):
        self.Ro = ro
        self.Po = ro(t)
        self.T = t
        self.E = e


class Sphere:
    def __init__(self, radius):
        self.radius = radius
    
    def intersect(self, r):
        a = r.D*r.D
        b = 2.0*(r.O*r.D)
        c = r.O*r.O - self.radius*self.radius
        t = kmath.quadratic(a, b, c)
        if len(t) > 0:
            if t[0] > 1E-3:
                return Intersection(r, t[0], self)
            if len(t) == 2 and t[1] > 1E-3:
                return Intersection(r, t[1], self)
        return None
    
    def surface_normal(self, it):
        return Triplet(it.Po.X, it.Po.Y, it.Po.Z)


class Cube:
    
    def __init__(self, radius):
        self.radius = radius
    
    def intersect(self, r):
        
        tx1 = (-self.radius - r.O.X)/r.D.X
        tx2 = (self.radius - r.O.X)/r.D.X

        tmin = min(tx1, tx2)
        tmax = max(tx1, tx2)

        ty1 = (-self.radius - r.O.Y)/r.D.Y
        ty2 = (self.radius - r.O.Y)/r.D.Y

        tmin = max(tmin, min(ty1, ty2))
        tmax = min(tmax, max(ty1, ty2))

        tz1 = (-self.radius - r.O.Z)/r.D.Z
        tz2 = (self.radius - r.O.Z)/r.D.Z

        tmin = max(tmin, min(tz1, tz2))
        tmax = min(tmax, max(tz1, tz2))

        if tmax >= max(0.0, tmin):
            if tmin > 1.0E-3:
                return Intersection(r, tmin, self)
            elif tmax > 1.0E-3:
                return Intersection(r, tmax, self)
        return None
    
    def get_normal(self, it):
        max_val = it.Po.X
        n = Triplet(kmath.sign(max_val), 0.0, 0.0)
        if abs(it.Po.Y) > abs(max_val):
            max_val = it.Po.Y
            n = Triplet(0.0, kmath.sign(max_val), 0.0)
        if abs(it.Po.Z) > abs(max_val):
            max_val = it.Po.Z
            n = Triplet(0.0, 0.0, kmath.sign(max_val))
        return n


