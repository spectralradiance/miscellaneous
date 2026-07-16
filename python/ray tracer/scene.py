
# ┬┌─┌─┐┬ ┬ ┬┌─┐┌┬┐┬─┐┌─┐
# ├┴┐├─┤│ └┬┘├─┘ │ ├┬┘├─┤
# ┴ ┴┴ ┴┴─┘┴ ┴   ┴ ┴└─┴ ┴

class Scene:
    def __init__(self):
        self.camera = None
        self.intersectables = []
        self.lights = []

    def find_intersection(self, rw):
        it = None
        for itr in self.intersectables:
            t = itr.intersect(rw)
            if it is None or t.T < it.T:
                it = t
        return it





