
// diasil.ts — TypeScript Raytracer (single file)
// Combines: dmath.ts, color.ts, geometry3.ts, light.ts, shape.ts, material.ts, camera.ts

// ==================== DMath ====================

class DMath {
    static quadratic(a: number, b: number, c: number): number[] {
        let disc: number = b * b - 4.0 * a * c;
        if (disc < 0.0) return [];
        if (disc < 1e-10) return [-b / (2.0 * a)];
        disc = Math.sqrt(disc);
        const q: number = b < 0.0 ? -0.5 * (b - disc) : -0.5 * (b + disc);
        const r0 = q / a;
        const r1 = c / q;
        return r0 < r1 ? [r0, r1] : [r1, r0];
    }
}

// ==================== RGBColor ====================

class RGBColor {
    static BLACK: RGBColor = new RGBColor(0, 0, 0);
    static WHITE: RGBColor = new RGBColor(1, 1, 1);

    R: number; G: number; B: number;

    constructor(r: number, g: number, b: number) {
        this.R = r; this.G = g; this.B = b;
    }

    add(c: RGBColor): RGBColor {
        return new RGBColor(this.R + c.R, this.G + c.G, this.B + c.B);
    }

    multiply(c: number | RGBColor): RGBColor {
        if (c instanceof RGBColor) {
            return new RGBColor(this.R * c.R, this.G * c.G, this.B * c.B);
        }
        return new RGBColor(this.R * c, this.G * c, this.B * c);
    }
}

// ==================== Geometry ====================

class Tuple3 {
    X: number; Y: number; Z: number;
    constructor(x: number, y: number, z: number) {
        this.X = x; this.Y = y; this.Z = z;
    }
}

class Point3 extends Tuple3 {
    constructor(x: number, y: number, z: number) { super(x, y, z); }
}

class Direction3 extends Tuple3 {
    constructor(x: number, y: number, z: number) { super(x, y, z); }
    lengthSquared(): number { return this.X * this.X + this.Y * this.Y + this.Z * this.Z; }
    length(): number { return Math.sqrt(this.lengthSquared()); }
    scale(s: number): void { this.X *= s; this.Y *= s; this.Z *= s; }
    normalize(): void { this.scale(1.0 / this.length()); }
    dot(v: Tuple3): number { return this.X * v.X + this.Y * v.Y + this.Z * v.Z; }
}

class Vector3 extends Direction3 {
    constructor(x: number | Tuple3, y?: number, z?: number) {
        if (x instanceof Tuple3) {
            super(x.X, x.Y, x.Z);
        } else {
            super(x as number, y!, z!);
        }
    }
}

class Normal3 extends Direction3 {
    constructor(x: number | Tuple3, y?: number, z?: number) {
        if (x instanceof Tuple3) {
            super(x.X, x.Y, x.Z);
        } else {
            super(x as number, y!, z!);
        }
    }
}

class Ray3 {
    O: Point3;
    D: Vector3;

    constructor(O: Point3, D: Direction3) {
        this.O = O;
        this.D = new Vector3(D.X, D.Y, D.Z);
    }

    pointAt(t: number): Point3 {
        return new Point3(
            this.O.X + t * this.D.X,
            this.O.Y + t * this.D.Y,
            this.O.Z + t * this.D.Z
        );
    }
}

// ==================== Matrix4x4 ====================

class Matrix4x4 {
    X00: number; X01: number; X02: number; X03: number;
    X10: number; X11: number; X12: number; X13: number;
    X20: number; X21: number; X22: number; X23: number;
    X30: number; X31: number; X32: number; X33: number;

    constructor() {
        this.X00 = 1; this.X01 = 0; this.X02 = 0; this.X03 = 0;
        this.X10 = 0; this.X11 = 1; this.X12 = 0; this.X13 = 0;
        this.X20 = 0; this.X21 = 0; this.X22 = 1; this.X23 = 0;
        this.X30 = 0; this.X31 = 0; this.X32 = 0; this.X33 = 1;
    }

    setAsIdentity(): void {
        this.X00 = 1; this.X01 = 0; this.X02 = 0; this.X03 = 0;
        this.X10 = 0; this.X11 = 1; this.X12 = 0; this.X13 = 0;
        this.X20 = 0; this.X21 = 0; this.X22 = 1; this.X23 = 0;
        this.X30 = 0; this.X31 = 0; this.X32 = 0; this.X33 = 1;
    }

    multiply(m: Matrix4x4): Matrix4x4 {
        const r = new Matrix4x4();
        r.X00 = this.X00*m.X00 + this.X01*m.X10 + this.X02*m.X20 + this.X03*m.X30;
        r.X01 = this.X00*m.X01 + this.X01*m.X11 + this.X02*m.X21 + this.X03*m.X31;
        r.X02 = this.X00*m.X02 + this.X01*m.X12 + this.X02*m.X22 + this.X03*m.X32;
        r.X03 = this.X00*m.X03 + this.X01*m.X13 + this.X02*m.X23 + this.X03*m.X33;
        r.X10 = this.X10*m.X00 + this.X11*m.X10 + this.X12*m.X20 + this.X13*m.X30;
        r.X11 = this.X10*m.X01 + this.X11*m.X11 + this.X12*m.X21 + this.X13*m.X31;
        r.X12 = this.X10*m.X02 + this.X11*m.X12 + this.X12*m.X22 + this.X13*m.X32;
        r.X13 = this.X10*m.X03 + this.X11*m.X13 + this.X12*m.X23 + this.X13*m.X33;
        r.X20 = this.X20*m.X00 + this.X21*m.X10 + this.X22*m.X20 + this.X23*m.X30;
        r.X21 = this.X20*m.X01 + this.X21*m.X11 + this.X22*m.X21 + this.X23*m.X31;
        r.X22 = this.X20*m.X02 + this.X21*m.X12 + this.X22*m.X22 + this.X23*m.X32;
        r.X23 = this.X20*m.X03 + this.X21*m.X13 + this.X22*m.X23 + this.X23*m.X33;
        r.X30 = this.X30*m.X00 + this.X31*m.X10 + this.X32*m.X20 + this.X33*m.X30;
        r.X31 = this.X30*m.X01 + this.X31*m.X11 + this.X32*m.X21 + this.X33*m.X31;
        r.X32 = this.X30*m.X02 + this.X31*m.X12 + this.X32*m.X22 + this.X33*m.X32;
        r.X33 = this.X30*m.X03 + this.X31*m.X13 + this.X32*m.X23 + this.X33*m.X33;
        return r;
    }

    getInverse(): Matrix4x4 {
        const s0 = this.X00*this.X11 - this.X10*this.X01;
        const s1 = this.X00*this.X12 - this.X10*this.X02;
        const s2 = this.X00*this.X13 - this.X10*this.X03;
        const s3 = this.X01*this.X12 - this.X11*this.X02;
        const s4 = this.X01*this.X13 - this.X11*this.X03;
        const s5 = this.X02*this.X13 - this.X12*this.X03;
        const c5 = this.X22*this.X33 - this.X32*this.X23;
        const c4 = this.X21*this.X33 - this.X31*this.X23;
        const c3 = this.X21*this.X32 - this.X31*this.X22;
        const c2 = this.X20*this.X33 - this.X30*this.X23;
        const c1 = this.X20*this.X32 - this.X30*this.X22;
        const c0 = this.X20*this.X31 - this.X30*this.X21;
        const inv_det = 1 / (s0*c5 - s1*c4 + s2*c3 + s3*c2 - s4*c1 + s5*c0);
        const m = new Matrix4x4();
        m.X00 =  (this.X11*c5 - this.X12*c4 + this.X13*c3) * inv_det;
        m.X01 = (-this.X01*c5 + this.X02*c4 - this.X03*c3) * inv_det;
        m.X02 =  (this.X31*s5 - this.X32*s4 + this.X33*s3) * inv_det;
        m.X03 = (-this.X21*s5 + this.X22*s4 - this.X23*s3) * inv_det;
        m.X10 = (-this.X10*c5 + this.X12*c2 - this.X13*c1) * inv_det;
        m.X11 =  (this.X00*c5 - this.X02*c2 + this.X03*c1) * inv_det;
        m.X12 = (-this.X30*s5 + this.X32*s2 - this.X33*s1) * inv_det;
        m.X13 =  (this.X20*s5 - this.X22*s2 + this.X23*s1) * inv_det;
        m.X20 =  (this.X10*c4 - this.X11*c2 + this.X13*c0) * inv_det;
        m.X21 = (-this.X00*c4 + this.X01*c2 - this.X03*c0) * inv_det;
        m.X22 =  (this.X30*s4 - this.X31*s2 + this.X33*s0) * inv_det;
        m.X23 = (-this.X20*s4 + this.X21*s2 - this.X23*s0) * inv_det;
        m.X30 = (-this.X10*c3 + this.X11*c1 - this.X12*c0) * inv_det;
        m.X31 =  (this.X00*c3 - this.X01*c1 + this.X02*c0) * inv_det;
        m.X32 = (-this.X30*s3 + this.X31*s1 - this.X32*s0) * inv_det;
        m.X33 =  (this.X20*s3 - this.X21*s1 + this.X22*s0) * inv_det;
        return m;
    }
}

// ==================== Transform3 ====================

class Transform3 {
    T: Matrix4x4;
    I: Matrix4x4;

    constructor() {
        this.T = new Matrix4x4();
        this.I = new Matrix4x4();
    }

    multiply(t: Transform3): Transform3 {
        const r = new Transform3();
        r.T = this.T.multiply(t.T);
        r.I = t.I.multiply(this.I);
        return r;
    }

    toWorldSpace(t: any): any {
        if (t instanceof Ray3) {
            return new Ray3(this.toWorldSpace(t.O), this.toWorldSpace(t.D));
        }
        if (t instanceof Normal3) {
            return new Normal3(
                this.I.X00 * t.X + this.I.X10 * t.Y + this.I.X20 * t.Z,
                this.I.X01 * t.X + this.I.X11 * t.Y + this.I.X21 * t.Z,
                this.I.X02 * t.X + this.I.X12 * t.Y + this.I.X22 * t.Z
            );
        }
        if (t instanceof Vector3) {
            return new Vector3(
                this.T.X00 * t.X + this.T.X01 * t.Y + this.T.X02 * t.Z,
                this.T.X10 * t.X + this.T.X11 * t.Y + this.T.X12 * t.Z,
                this.T.X20 * t.X + this.T.X21 * t.Y + this.T.X22 * t.Z
            );
        }
        if (t instanceof Point3) {
            const tx = this.T.X00*t.X + this.T.X01*t.Y + this.T.X02*t.Z + this.T.X03;
            const ty = this.T.X10*t.X + this.T.X11*t.Y + this.T.X12*t.Z + this.T.X13;
            const tz = this.T.X20*t.X + this.T.X21*t.Y + this.T.X22*t.Z + this.T.X23;
            const w  = this.T.X30*t.X + this.T.X31*t.Y + this.T.X32*t.Z + this.T.X33;
            if (w !== 1.0) {
                const inv_w = 1.0 / w;
                return new Point3(tx * inv_w, ty * inv_w, tz * inv_w);
            }
            return new Point3(tx, ty, tz);
        }
        return null;
    }

    toObjectSpace(t: any): any {
        if (t instanceof Ray3) {
            return new Ray3(this.toObjectSpace(t.O), this.toObjectSpace(t.D));
        }
        if (t instanceof Normal3) {
            return new Normal3(
                this.T.X00*t.X + this.T.X10*t.Y + this.T.X20*t.Z,
                this.T.X01*t.X + this.T.X11*t.Y + this.T.X21*t.Z,
                this.T.X02*t.X + this.T.X12*t.Y + this.T.X22*t.Z
            );
        }
        if (t instanceof Vector3) {
            return new Vector3(
                this.I.X00*t.X + this.I.X01*t.Y + this.I.X02*t.Z,
                this.I.X10*t.X + this.I.X11*t.Y + this.I.X12*t.Z,
                this.I.X20*t.X + this.I.X21*t.Y + this.I.X22*t.Z
            );
        }
        if (t instanceof Point3) {
            const tx = this.I.X00*t.X + this.I.X01*t.Y + this.I.X02*t.Z + this.I.X03;
            const ty = this.I.X10*t.X + this.I.X11*t.Y + this.I.X12*t.Z + this.I.X13;
            const tz = this.I.X20*t.X + this.I.X21*t.Y + this.I.X22*t.Z + this.I.X23;
            const w  = this.I.X30*t.X + this.I.X31*t.Y + this.I.X32*t.Z + this.I.X33;
            if (w !== 1.0) {
                const inv_w = 1.0 / w;
                return new Point3(tx * inv_w, ty * inv_w, tz * inv_w);
            }
            return new Point3(tx, ty, tz);
        }
        return null;
    }

    setAsIdentity(): void {
        this.T.setAsIdentity();
        this.I.setAsIdentity();
    }

    setAsTranslator(x: number, y: number, z: number): void {
        this.setAsIdentity();
        this.T.X03 =  x; this.T.X13 =  y; this.T.X23 =  z;
        this.I.X03 = -x; this.I.X13 = -y; this.I.X23 = -z;
    }

    setAsScaler(x: number, y: number, z: number): void {
        this.setAsIdentity();
        this.T.X00 = x;   this.T.X11 = y;   this.T.X22 = z;
        this.I.X00 = 1/x; this.I.X11 = 1/y; this.I.X22 = 1/z;
    }
}

// ==================== CoordinateSystem3 ====================

class CoordinateSystem3 {
    transform: Transform3;
    constructor() { this.transform = new Transform3(); }
    toWorldSpace(x: any): any  { return this.transform.toWorldSpace(x); }
    toObjectSpace(x: any): any { return this.transform.toObjectSpace(x); }
}

// ==================== LightVector ====================

class LightVector extends Vector3 {
    color: RGBColor;
    constructor(v: Vector3, c: RGBColor) {
        super(v.X, v.Y, v.Z);
        this.color = c;
    }
}

// ==================== Surface Geometry ====================

class SurfaceGeometry {
    P: Point3; N: Normal3; V: Vector3;
    constructor(p: Point3, n: Normal3, v: Vector3) {
        this.P = p; this.N = n; this.V = v;
    }
}

// ==================== Intersection ====================

class Intersection {
    Ro: Ray3; Po: Point3;
    Rw: Ray3; Pw: Point3;
    T: number;
    shape: Shape;

    constructor(rw: Ray3, ro: Ray3, t: number, shape: Shape) {
        this.Rw = rw;
        this.Pw = rw.pointAt(t);
        this.Ro = ro;
        this.Po = ro.pointAt(t);
        this.T = t;
        this.shape = shape;
    }
}

// ==================== Shape ====================

abstract class Shape extends CoordinateSystem3 {
    abstract intersectWith(ray: Ray3): Intersection | null;
    abstract getSurfaceGeometry(it: Intersection): SurfaceGeometry;
    abstract getMaterial(): Material;
}

// ==================== Sphere ====================

class Sphere extends Shape {
    radius: number;
    material: Material;

    constructor(radius: number, material: Material) {
        super();
        this.radius = radius;
        this.material = material;
    }

    intersectWith(rw: Ray3): Intersection | null {
        const ro: Ray3 = this.toObjectSpace(rw);
        const a = ro.D.dot(ro.D);
        const b = 2 * (ro.O.X*ro.D.X + ro.O.Y*ro.D.Y + ro.O.Z*ro.D.Z);
        const c = (ro.O.X*ro.O.X + ro.O.Y*ro.O.Y + ro.O.Z*ro.O.Z) - this.radius * this.radius;
        const t: number[] = DMath.quadratic(a, b, c);
        if (t.length > 0) {
            if (t[0] > 1e-3) return new Intersection(rw, ro, t[0], this);
            if (t.length === 2 && t[1] > 1e-3) return new Intersection(rw, ro, t[1], this);
        }
        return null;
    }

    getSurfaceGeometry(it: Intersection): SurfaceGeometry {
        const p: Point3 = it.Po;
        const n: Normal3 = new Normal3(p.X, p.Y, p.Z);
        n.normalize();
        const v: Vector3 = new Vector3(it.Ro.D);
        v.scale(-1);
        return new SurfaceGeometry(p, n, v);
    }

    getMaterial(): Material {
        return this.material;
    }
}

// ==================== Material ====================

interface Material {
    getColor(sg: SurfaceGeometry, lv: LightVector): RGBColor;
}

class LambertianReflectance implements Material {
    color: RGBColor;

    constructor(c: RGBColor) { this.color = c; }

    getColor(sg: SurfaceGeometry, lv: LightVector): RGBColor {
        // Lambertian: material_color * light_color * max(0, N·L)
        const ndotl = Math.max(0, lv.dot(sg.N));
        return this.color.multiply(lv.color).multiply(ndotl);
    }
}

// ==================== Light ====================

interface Light {
    colorAt(p: Point3): LightVector[];
}

class PointLight extends CoordinateSystem3 implements Light {
    color: RGBColor;

    constructor(color: RGBColor) {
        super();
        this.color = color;
    }

    colorAt(p: Point3): LightVector[] {
        const o: Point3 = this.toWorldSpace(new Point3(0, 0, 0));
        const d = new Vector3(o.X - p.X, o.Y - p.Y, o.Z - p.Z);
        // Attenuate by inverse square of distance
        const c = this.color.multiply(1 / d.lengthSquared());
        d.normalize();
        return [new LightVector(d, c)];
    }
}

// ==================== Camera ====================

interface Camera {
    generateRay(x: number, y: number, width: number, height: number): Ray3;
}

class PerspectiveCamera extends CoordinateSystem3 implements Camera {
    focal_length: number;

    constructor(focal_length: number) {
        super();
        this.focal_length = focal_length;
    }

    generateRay(x: number, y: number, width: number, height: number): Ray3 {
        const xp: number = 2.0 * x / width  - 1.0;
        const yp: number = 2.0 * y / height - 1.0;
        let r: Ray3 = new Ray3(
            new Point3(0, 0, 0),
            new Vector3(xp, yp, this.focal_length)
        );
        r = this.toWorldSpace(r);
        r.D.normalize();
        return r;
    }
}

// ==================== Scene ====================

class Scene {
    shapes: Shape[];
    lights: Light[];
    camera: Camera;

    constructor() {
        this.shapes = [];
        this.lights = [];
        this.camera = new PerspectiveCamera(1.0);
    }

    intersectWith(r: Ray3): Intersection | null {
        let closest: Intersection | null = null;
        for (const shape of this.shapes) {
            const it = shape.intersectWith(r);
            if (it !== null && (closest === null || it.T < closest.T)) {
                closest = it;
            }
        }
        return closest;
    }
}

// ==================== Render ====================

window.onload = () => {
    const cnv = document.querySelector('#cnv') as HTMLCanvasElement;
    const ctx = cnv.getContext('2d')!;

    // Allocate a single ImageData buffer for the entire canvas (much faster than per-pixel putImageData)
    const imageData = ctx.createImageData(cnv.width, cnv.height);
    const pixels = imageData.data;

    function setPixel(x: number, y: number, c: RGBColor): void {
        const idx = (y * cnv.width + x) * 4;
        pixels[idx + 0] = Math.floor(Math.min(1, Math.max(0, c.R)) * 255);
        pixels[idx + 1] = Math.floor(Math.min(1, Math.max(0, c.G)) * 255);
        pixels[idx + 2] = Math.floor(Math.min(1, Math.max(0, c.B)) * 255);
        pixels[idx + 3] = 255;
    }

    // Scene setup
    const scene = new Scene();

    const white_matte: Material = new LambertianReflectance(RGBColor.WHITE);
    const sphere = new Sphere(1, white_matte);       // radius 1, centered at origin
    scene.shapes.push(sphere);

    const camera = new PerspectiveCamera(4.0);       // focal length 4 → sphere fills canvas
    camera.transform.setAsTranslator(0, 0, -4);      // camera 4 units behind the sphere
    scene.camera = camera;

    // Light intensity 100 compensates for 1/r^2 falloff at ~16 unit distance
    const light = new PointLight(new RGBColor(100, 100, 100));
    light.transform.setAsTranslator(-10, -10, -10);
    scene.lights.push(light);

    // Render loop — Lambertian shading with hard shadows
    for (let x = 0; x < cnv.width; ++x) {
        for (let y = 0; y < cnv.height; ++y) {
            const rw: Ray3 = scene.camera.generateRay(x, y, cnv.width, cnv.height);
            const it: Intersection | null = scene.intersectWith(rw);

            if (it === null) {
                setPixel(x, y, RGBColor.BLACK);
                continue;
            }

            const sg: SurfaceGeometry = it.shape.getSurfaceGeometry(it);
            const material: Material = it.shape.getMaterial();

            let pixel_color: RGBColor = new RGBColor(0, 0, 0);
            for (let i = 0; i < scene.lights.length; ++i) {
                const lvs: LightVector[] = scene.lights[i].colorAt(it.Pw);
                for (let j = 0; j < lvs.length; ++j) {
                    // Shadow ray: fire from world-space hit point toward the light
                    const shadow_ray: Ray3 = new Ray3(it.Pw, lvs[j]);
                    if (scene.intersectWith(shadow_ray) === null) {
                        pixel_color = pixel_color.add(material.getColor(sg, lvs[j]));
                    }
                }
            }
            setPixel(x, y, pixel_color);
        }
    }

    ctx.putImageData(imageData, 0, 0);
};

