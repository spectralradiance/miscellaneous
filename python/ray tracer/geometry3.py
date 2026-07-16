
# ┬┌─┌─┐┬ ┬ ┬┌─┐┌┬┐┬─┐┌─┐
# ├┴┐├─┤│ └┬┘├─┘ │ ├┬┘├─┤
# ┴ ┴┴ ┴┴─┘┴ ┴   ┴ ┴└─┴ ┴

import math


class Triplet:
    def __init__(self, x=0.0, y=0.0, z=0.0):
        self.X = x
        self.Y = y
        self.Z = z

    def __getitem__(self, i):
        if i == 0:
            return self.X
        elif i == 1:
            return self.Y
        return self.Z

    def __sub__(self, p):
        return Triplet(self.X-p.X, self.Y-p.Y, self.Z-p.Z)

    def __mul__(self, v):
        if type(v) is float:
            return Triplet(self.X*v, self.Y*v, self.Z*v)
        return self.X*v.X + self.Y*v.Y + self.Z*v.Z

    __rmul__ = __mul__

    def length_squared(self):
        return self.X*self.X + self.Y*self.Y + self.Z*self.Z

    def length(self):
        return math.sqrt(self.length_squared())
    
    def normalize(self):
        inv = 1.0/self.length()
        self.X *= inv
        self.Y *= inv
        self.Z *= inv

    def distance_squared(self, p):
        dx = self.X - p.X
        dy = self.Y - p.Y
        dz = self.Z - p.Z
        return dx*dx + dy*dy + dz*dz

    def distance(self, p):
        return math.sqrt(self.distance_squared(p))
    
    def __str__(self):
        return f'[{self.X},{self.Y},{self.Z}]'


class Ray3:
    
    def __init__(self, o, d):
        self.O = o
        self.D = d

    def __call__(self, t):
        px = self.O.X + t*self.D.X
        py = self.O.Y + t*self.D.Y
        pz = self.O.Z + t*self.D.Z


class BBox:

    def __init__(self, pmin, pmax):
        self.pmin = pmin
        self.pmax = pmax

    def union(self, b):
        if b.pmin.X < self.pmin.X:
            self.pmin.X = b.pmin.X
        if b.pmin.Y < self.pmin.Y:
            self.pmin.Y = b.pmin.Y
        if b.pmin.Z < self.pmin.Z:
            self.pmin.Z = b.pmin.Z
        if b.pmax.X > self.pmax.X:
            self.pmax.X = b.pmax.X
        if b.pmax.Y > self.pmax.Y:
            self.pmax.Y = b.pmax.Y
        if b.pmax.Z > self.pmax.Z:
            self.pmax.Z = b.pmax.Z


class Matrix4x4:

    def __init__(self):
        self.set_as_identity()

    def set_as_identity(self):
        
        self.X00 = 1.0
        self.X01 = 0.0
        self.X02 = 0.0
        self.X03 = 0.0

        self.X10 = 0.0
        self.X11 = 1.0
        self.X12 = 0.0
        self.X13 = 0.0

        self.X20 = 0.0
        self.X21 = 0.0
        self.X22 = 1.0
        self.X23 = 0.0

        self.X30 = 0.0
        self.X31 = 0.0
        self.X32 = 0.0
        self.X33 = 1.0


class Transform3:

    def __init__(self):
        self.M = Matrix4x4()
        self.I = Matrix4x4()

    def transform_point(self, p):
        tx = self.M.X00*p.X + self.M.X01*p.Y + self.M.X02*p.Z + self.M.X03
        ty = self.M.X10*p.X + self.M.X11*p.Y + self.M.X12*p.Z + self.M.X13
        tz = self.M.X20*p.X + self.M.X21*p.Y + self.M.X22*p.Z + self.M.X23
        w  = self.M.X30*p.X + self.M.X31*p.Y + self.M.X32*p.Z + self.M.X33
        if w != 1.0:
            inv_w = 1.0 / w
            return Triplet(tx*inv_w, ty*inv_w, tz*inv_w)
        return Triplet(tx, ty, tz)

    def invert_point(self, p):
        tx = self.I.X00*p.X + self.I.X01*p.Y + self.I.X02*p.Z + self.I.X03
        ty = self.I.X10*p.X + self.I.X11*p.Y + self.I.X12*p.Z + self.I.X13
        tz = self.I.X20*p.X + self.I.X21*p.Y + self.I.X22*p.Z + self.I.X23
        w  = self.I.X30*p.X + self.I.X31*p.Y + self.I.X32*p.Z + self.I.X33
        if w != 1.0:
            inv_w = 1.0 / w
            return Triplet(tx*inv_w, ty*inv_w, tz*inv_w)
        return Triplet(tx, ty, tz)

    def transform_vector(self, v):
        return Triplet(self.M.X00*v.X + self.M.X01*v.Y + self.M.X02*v.Z,
                       self.M.X10*v.X + self.M.X11*v.Y + self.M.X12*v.Z,
                       self.M.X20*v.X + self.M.X21*v.Y + self.M.X22*v.Z)

    def invert_vector(self, v):
        return Triplet(self.I.X00*v.X + self.I.X01*v.Y + self.I.X02*v.Z,
                       self.I.X10*v.X + self.I.X11*v.Y + self.I.X12*v.Z,
                       self.I.X20*v.X + self.I.X21*v.Y + self.I.X22*v.Z)

    def transform_normal(self, n):
        return Triplet(self.I.X00*n.X + self.I.X10*n.Y + self.I.X20*n.Z,
                       self.I.X01*n.X + self.I.X11*n.Y + self.I.X21*n.Z,
                       self.I.X02*n.X + self.I.X12*n.Y + self.I.X22*n.Z)

    def invert_normal(self, n):
        return Triplet(self.M.X00*n.X + self.M.X10*n.Y + self.M.X20*n.Z,
                       self.M.X01*n.X + self.M.X11*n.Y + self.M.X21*n.Z,
                       self.M.X02*n.X + self.M.X12*n.Y + self.M.X22*n.Z)

    @staticmethod
    def identity():
        return Transform3()

    @staticmethod
    def translator(tx, ty, tz):
        t = Transform3()
        t.M.X03 = tx
        t.M.X13 = ty
        t.M.X23 = tz
        t.I.X03 = -tx
        t.I.X13 = -ty
        t.I.X23 = -tz
        return t
    
    @staticmethod
    def scaler(sx, sy, sz):
        t = Transform3()
        t.M.X00 = sx
        t.M.X11 = sy
        t.M.X22 = sz
        t.I.X00 = 1.0/sx
        t.I.X11 = 1.0/sy
        t.I.X22 = 1.0/sz

    @staticmethod
    def rotate_xy(angle):
        ca = math.cos(angle)
        sa = math.sin(angle)
        t = Transform3()
        t.M.X00 = ca
        t.M.X01 = -sa
        t.M.X10 = sa
        t.M.X11 = ca
        t.I.X00 = ca
        t.I.X01 = sa
        t.I.X10 = -sa
        t.I.X11 = ca
        return t

    @staticmethod
    def rotate_xz(angle):
        ca = math.cos(angle)
        sa = math.sin(angle)
        t = Transform3()
        t.M.X00 = ca
        t.M.X02 = -sa
        t.M.X20 = sa
        t.M.X22 = ca
        t.I.X00 = ca
        t.I.X02 = sa
        t.I.X20 = -sa
        t.I.X22 = ca
        return t

    @staticmethod
    def rotate_yz(angle):
        ca = math.cos(angle)
        sa = math.sin(angle)
        t = Transform3()
        t.M.X11 = ca
        t.M.X12 = -sa
        t.M.X21 = sa
        t.M.X22 = ca
        t.I.X11 = ca
        t.I.X12 = sa
        t.I.X21 = -sa
        t.I.X22 = ca
        return t


