
class RGBColor:

    def __init__(self, r=0.0, g=0.0, b=0.0):
        self.R = r
        self.G = g
        self.B = b

    def __add__(self, c):
        return RGBColor(self.R+c.R, self.G+c.G, self.B+c.B)

    def __sub__(self, c):
        return RGBColor(self.R-c.R, self.G-c.G, self.B-c.B)

    def __mul__(self, v):
        return RGBColor(self.R*v, self.G*v, self.B*v)

    __rmul__ = __mul__

