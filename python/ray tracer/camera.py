
# ┬┌─┌─┐┬ ┬ ┬┌─┐┌┬┐┬─┐┌─┐
# ├┴┐├─┤│ └┬┘├─┘ │ ├┬┘├─┤
# ┴ ┴┴ ┴┴─┘┴ ┴   ┴ ┴└─┴ ┴

from geometry3 import Triplet, Ray3

class Camera:
        
    def __init__(self, p):
        self.project_plane = p
    
    def generate_ray(self, x, y, w, h):
        s = max(w, h)
        xp = 2.0*x/s - 1.0
        yp = 2.0*y/s - 1.0
        o = Triplet(0.0, 0.0, -10.0)
        d = Triplet(xp, yp, self.project_plane)
        return Ray3(o, d)

