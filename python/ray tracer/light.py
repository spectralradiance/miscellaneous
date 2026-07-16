

class PointLight:
    
    def __init__(self, origin, power):
        self.origin = origin
        self.power = power

    def intensity(self, p):
        v = self.origin - p
        d2 = v.length_squared()
        color = self.power / d2
        return color, v
