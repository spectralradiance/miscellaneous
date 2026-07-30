import React, { useState, useRef, useEffect } from 'react';

class PState {
  constructor(mp) {
    this.width = mp.width;
    this.height = mp.height;
    this.wo2 = mp.width / 2;
    this.ho2 = mp.height / 2;
    this.data = [];
    for (let i = 0; i < mp.width; ++i) {
      let t = [];
      for (let j = 0; j < mp.height; ++j) {
        t.push(mp.transparency ? -1 : 0);
      }
      this.data.push(t);
    }
  }
  replaceColor(v1, v2) {
    for (let i = 0; i < this.width; ++i) {
      for (let j = 0; j < this.height; ++j) {
        if (this.data[i][j] === v1) {
          this.data[i][j] = v2;
        }
      }
    }
  }
  swapColors(v1, v2) {
    for (let i = 0; i < this.width; ++i) {
      for (let j = 0; j < this.height; ++j) {
        if (this.data[i][j] === v1) {
          this.data[i][j] = v2;
        } else if (this.data[i][j] === v2) {
          this.data[i][j] = v1;
        }
      }
    }
  }
  adjustSize(mp) {
    let nd = [];
    for (let i = 0; i < mp.width; ++i) {
      let t = [];
      for (let j = 0; j < mp.height; ++j) {
        if (i < this.width && j < this.height) {
          t.push(this.data[i][j]);
        } else {
          t.push(mp.transparency ? -1 : 0);
        }
      }
      nd.push(t);
    }
    this.width = mp.width;
    this.height = mp.height;
    this.wo2 = mp.width / 2;
    this.ho2 = mp.height / 2;
    this.data = nd;
  }
  clone(mp) {
    let r = new PState(mp);
    for (let i = 0; i < this.width; ++i) {
      for (let j = 0; j < this.height; ++j) {
        r.data[i][j] = this.data[i][j];
      }
    }
    return r;
  }
  toCenter(p) {
    return [p[0] - this.wo2, p[1] - this.ho2];
  }
  fromCenter(p) {
    return [p[0] + this.wo2, p[1] + this.ho2];
  }
}

function createGrayscalePalette(n_grey) {
  let r = [];
  let s = 255 / (n_grey - 1);
  for (let i = 0; i < n_grey; ++i) {
    let c = i * s;
    r.push([c, c, c, 255]);
  }
  return r;
}

function Apax() {
  const [mp, setMp] = useState({ width: 64, height: 64, scale: 6, transparency: false });
  const [palette, setPalette] = useState(createGrayscalePalette(4));
  const [brush, setBrush] = useState(3);
  const [symmetries, setSymmetries] = useState([
    { type: 'reflect', value: '|' },
    { type: 'tile', nx: 4, ny: 4 }
  ]);
  const [state, setState] = useState(new PState(mp));
  const canvasRef = useRef(null);
  const [mouseDown, setMouseDown] = useState(false);

  useEffect(() => {
    refreshState();
    // eslint-disable-next-line
  }, [mp]);

  function refreshState() {
    let s = state.clone(mp);
    s.adjustSize(mp);
    setState(s);
    let canvas = canvasRef.current;
    if (canvas) {
      canvas.width = mp.width * mp.scale;
      canvas.height = mp.height * mp.scale;
      renderImage(s);
    }
  }

  function renderImage(s) {
    let canvas = canvasRef.current;
    if (!canvas) return;
    let ctx = canvas.getContext('2d');
    let img_data = ctx.createImageData(canvas.width, canvas.height);
    for (let i = 0; i < s.width; ++i) {
      for (let j = 0; j < s.height; ++j) {
        let v = s.data[i][j];
        let c = v === -1 ? [0, 0, 0, 0] : palette[v];
        for (let m = 0; m < mp.scale; ++m) {
          let ni = i * mp.scale + m;
          for (let n = 0; n < mp.scale; ++n) {
            let nj = j * mp.scale + n;
            let index = (ni + nj * canvas.width) * 4;
            img_data.data[index + 0] = c[0];
            img_data.data[index + 1] = c[1];
            img_data.data[index + 2] = c[2];
            img_data.data[index + 3] = c[3];
          }
        }
      }
    }
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.putImageData(img_data, 0, 0, 0, 0, canvas.width, canvas.height);
  }

  function screenToImage(e) {
    let canvas = canvasRef.current;
    let rect = canvas.getBoundingClientRect();
    let p = [e.clientX - rect.left, e.clientY - rect.top];
    p[0] = Math.floor((p[0] / canvas.width) * state.width);
    p[1] = Math.floor((p[1] / canvas.height) * state.height);
    return p;
  }

  function drawPixel(p, v) {
    let pts = [p];
    for (let i = 0; i < symmetries.length; ++i) {
      let pts2 = [];
      for (let j = 0; j < pts.length; ++j) {
        pts2 = pts2.concat(transform(symmetries[i], pts[j]));
      }
      pts = pts2;
    }
    let s = state.clone(mp);
    for (let i = 0; i < pts.length; ++i) {
      if (
        pts[i][0] >= 0 &&
        pts[i][0] < s.width &&
        pts[i][1] >= 0 &&
        pts[i][1] < s.height
      ) {
        s.data[pts[i][0]][pts[i][1]] = v;
      }
    }
    setState(s);
    renderImage(s);
  }

  function transform(sym, p) {
    // Only reflect and tile implemented for brevity
    if (sym.type === 'reflect') {
      let ai = p[0], aj = p[1];
      let bi = state.width - ai - 1, bj = state.height - aj - 1;
      if (sym.value === '|') {
        return [[ai, aj], [bi, aj]];
      } else if (sym.value === '-') {
        return [[ai, aj], [ai, bj]];
      } else if (sym.value === '\\') {
        return [[ai, aj], [aj, ai]];
      } else if (sym.value === '/') {
        return [[ai, aj], [bj, bi]];
      }
    } else if (sym.type === 'tile') {
      let sx = Math.floor(state.width / sym.nx);
      let sy = Math.floor(state.height / sym.ny);
      let r = [];
      let ox = p[0] % sx;
      let oy = p[1] % sy;
      for (let i = 0; i < sym.nx; ++i) {
        for (let j = 0; j < sym.ny; ++j) {
          r.push([ox + i * sx, oy + j * sy]);
        }
      }
      return r;
    }
    return [p];
  }

  function handleMouseDown(e) {
    if (e.button === 0) {
      let p = screenToImage(e);
      drawPixel(p, brush);
      setMouseDown(true);
    }
  }
  function handleMouseMove(e) {
    if (mouseDown) {
      let p = screenToImage(e);
      drawPixel(p, brush);
    }
  }
  function handleMouseUp(e) {
    setMouseDown(false);
  }
  function handleMouseLeave(e) {
    setMouseDown(false);
  }

  function clearImage() {
    let s = state.clone(mp);
    for (let i = 0; i < s.width; ++i) {
      for (let j = 0; j < s.height; ++j) {
        s.data[i][j] = mp.transparency ? -1 : 0;
      }
    }
    setState(s);
    renderImage(s);
  }

  function saveImage() {
    let canvas = canvasRef.current;
    window.open(canvas.toDataURL('image/png'));
  }

  // Palette controls
  function addColorToPalette() {
    setPalette([...palette, [0,0,0,255]]);
  }
  function removeColor(i) {
    if (palette.length > 1) {
      let newPalette = palette.slice();
      newPalette.splice(i, 1);
      setPalette(newPalette);
      let s = state.clone(mp);
      s.replaceColor(i, mp.transparency ? -1 : 0);
      setState(s);
      if (brush === i) setBrush(0);
      renderImage(s);
    }
  }
  function moveColorUp(i) {
    if (i > 0) {
      let newPalette = palette.slice();
      [newPalette[i], newPalette[i-1]] = [newPalette[i-1], newPalette[i]];
      setPalette(newPalette);
      let s = state.clone(mp);
      s.swapColors(i, i-1);
      setState(s);
      if (brush === i) setBrush(i-1);
      else if (brush === i-1) setBrush(i);
      renderImage(s);
    }
  }
  function moveColorDown(i) {
    if (i < palette.length-1) {
      let newPalette = palette.slice();
      [newPalette[i], newPalette[i+1]] = [newPalette[i+1], newPalette[i]];
      setPalette(newPalette);
      let s = state.clone(mp);
      s.swapColors(i, i+1);
      setState(s);
      if (brush === i) setBrush(i+1);
      else if (brush === i+1) setBrush(i);
      renderImage(s);
    }
  }

  // Symmetry controls
  function addSymmetry() {
    setSymmetries([...symmetries, { type: 'none', value: 0 }]);
  }
  function removeSymmetry(i) {
    let newSyms = symmetries.slice();
    newSyms.splice(i, 1);
    setSymmetries(newSyms);
  }
  function moveSymmetryUp(i) {
    if (i > 0) {
      let newSyms = symmetries.slice();
      [newSyms[i], newSyms[i-1]] = [newSyms[i-1], newSyms[i]];
      setSymmetries(newSyms);
    }
  }
  function moveSymmetryDown(i) {
    if (i < symmetries.length-1) {
      let newSyms = symmetries.slice();
      [newSyms[i], newSyms[i+1]] = [newSyms[i+1], newSyms[i]];
      setSymmetries(newSyms);
    }
  }
  function setSymmetryType(i, type) {
    let newSyms = symmetries.slice();
    let sym = { ...newSyms[i] };
    sym.type = type;
    if (type === 'rotate') sym.n_sectors = 2;
    else if (type === 'reflect') sym.value = '|';
    else if (type === 'tile') { sym.nx = 2; sym.ny = 2; }
    newSyms[i] = sym;
    setSymmetries(newSyms);
  }
  function setRotator(i, n_sectors) {
    let newSyms = symmetries.slice();
    let sym = { ...newSyms[i], n_sectors: n_sectors };
    let a = 2 * Math.PI / n_sectors;
    sym.ca = Math.cos(a);
    sym.sa = Math.sin(a);
    newSyms[i] = sym;
    setSymmetries(newSyms);
  }
  function setTileParams(i, nx, ny) {
    let newSyms = symmetries.slice();
    let sym = { ...newSyms[i], nx: nx, ny: ny };
    newSyms[i] = sym;
    setSymmetries(newSyms);
  }
  function setReflectValue(i, value) {
    let newSyms = symmetries.slice();
    let sym = { ...newSyms[i], value: value };
    newSyms[i] = sym;
    setSymmetries(newSyms);
  }

  // UI rendering
  return (
    <div>
      <canvas
        ref={canvasRef}
        id="cmain"
        style={{ border: '1px solid black', cursor: 'crosshair' }}
        width={mp.width * mp.scale}
        height={mp.height * mp.scale}
        onMouseDown={handleMouseDown}
        onMouseMove={handleMouseMove}
        onMouseUp={handleMouseUp}
        onMouseLeave={handleMouseLeave}
      />
      <div style={{ marginTop: 10 }}>
        <button onClick={clearImage}>Clear</button>
        <button onClick={saveImage}>Save</button>
        <span style={{ marginLeft: 10 }}>Brush:</span>
        {palette.map((color, idx) => (
          <span key={idx} style={{ display: 'inline-block', marginRight: 4 }}>
            <button
              style={{
                background: `rgba(${color[0]},${color[1]},${color[2]},${color[3] / 255})`,
                border: brush === idx ? '2px solid red' : '1px solid gray',
                width: 24,
                height: 24,
                margin: 2
              }}
              onClick={() => setBrush(idx)}
            />
            <button onClick={() => moveColorUp(idx)} disabled={idx === 0}>↑</button>
            <button onClick={() => moveColorDown(idx)} disabled={idx === palette.length-1}>↓</button>
            <button onClick={() => removeColor(idx)} disabled={palette.length === 1}>✕</button>
          </span>
        ))}
        <button onClick={addColorToPalette}>Add Color</button>
      </div>
      <div style={{ marginTop: 20 }}>
        <h4>Symmetries / Transforms</h4>
        {symmetries.map((sym, idx) => (
          <div key={idx} style={{ marginBottom: 8, border: '1px solid #ccc', padding: 4 }}>
            <select value={sym.type} onChange={e => setSymmetryType(idx, e.target.value)}>
              <option value="none">None</option>
              <option value="reflect">Reflect</option>
              <option value="rotate">Rotate</option>
              <option value="tile">Tile</option>
            </select>
            {sym.type === 'reflect' && (
              <select value={sym.value} onChange={e => setReflectValue(idx, e.target.value)}>
                <option value="|">Vertical</option>
                <option value="-">Horizontal</option>
                <option value="\">Diagonal \\</option>
                <option value="/">Diagonal /</option>
              </select>
            )}
            {sym.type === 'rotate' && (
              <input type="number" min={2} max={16} value={sym.n_sectors || 2} onChange={e => setRotator(idx, parseInt(e.target.value))} />
            )}
            {sym.type === 'tile' && (
              <span>
                nx: <input type="number" min={1} max={16} value={sym.nx || 2} onChange={e => setTileParams(idx, parseInt(e.target.value), sym.ny || 2)} />
                ny: <input type="number" min={1} max={16} value={sym.ny || 2} onChange={e => setTileParams(idx, sym.nx || 2, parseInt(e.target.value))} />
              </span>
            )}
            <button onClick={() => moveSymmetryUp(idx)} disabled={idx === 0}>↑</button>
            <button onClick={() => moveSymmetryDown(idx)} disabled={idx === symmetries.length-1}>↓</button>
            <button onClick={() => removeSymmetry(idx)}>✕</button>
          </div>
        ))}
        <button onClick={addSymmetry}>Add Symmetry</button>
      </div>
    </div>
  );
}

export default Apax;
