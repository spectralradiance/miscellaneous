
from PIL import Image

# TODO: find palette that has complementary relationships
# option 1 - find the palette using PIL, adjust to be more symmetrical
# find the closest symmetrical form, have a parameter which interpolates between the palette and the closest symmetry
# try to emphasize existing symmetries
# equidistant from eachother in hue, in a line, etc


def color_distance(a, b):
    r = 0
    for i in range(len(a)):
        diff = a[i] - b[i]
        r += diff*diff
    return r


def closest_color(color, palette):
    cc = None
    for pc in palette:
        if cc is None or color_distance(color, pc) < color_distance(color, cc):
            cc = pc
    return cc


def shrink_then_quanitize(input_path, scale, n_colors):
    img = Image.open(input_path)
    input_width, input_height = img.size
    shrunk_width = input_width // scale
    shrunk_height = input_height // scale
    shrunk = img.resize((shrunk_width, shrunk_height), Image.ANTIALIAS)
    restored = shrunk.resize((shrunk_width * scale, shrunk_height * scale))
    quantized = restored.convert('P', palette=Image.ADAPTIVE, colors=n_colors)
    return quantized


def quantize_then_shrink(input_path, scale, n_colors):
    img = Image.open(input_path)
    input_width, input_height = img.size
    quantized = img.convert('P', palette=Image.ADAPTIVE, colors=n_colors)
    shrunk_width = input_width // scale
    shrunk_height = input_height // scale
    shrunk = quantized.resize((shrunk_width, shrunk_height), Image.ANTIALIAS)
    restored = shrunk.resize((shrunk_width*scale, shrunk_height*scale), Image.ANTIALIAS)
    return restored


def pixelate_image(input_path, scale, n_colors):

    img = Image.open(input_path)
    input_width, input_height = img.size

    result = img.convert('P', palette=Image.ADAPTIVE, colors=n_colors)
    palette = []
    result_palette = result.palette.palette  # TODO: change to getpalette()
    i = 0
    while i < len(result_palette):
        r = int(result_palette[i])
        g = int(result_palette[i+1])
        b = int(result_palette[i+2])
        palette.append((r, g, b))
        i += 3

    while len(palette) > n_colors and (0, 0, 0) in palette:
        palette.remove((0, 0, 0))

    shrunk_width = input_width // scale
    shrunk_height = input_height // scale
    #shrunk_image = img.thumbnail((100, 100), PIL.Image.ANTIALIAS)
    shrunk_image = img.resize((shrunk_width, shrunk_height), Image.ANTIALIAS)

    pixels = shrunk_image.load()
    for i in range(shrunk_width):
        for j in range(shrunk_height):
            pixels[i, j] = closest_color(pixels[i, j], palette)


    output = shrunk_image.resize((input_width, input_height))
    return output


input_path = 'D:\data\Lenna.png'
#input_path = r'E:\Google Drive\personal\photographs\upload4\20171031-temp\New folder\DSC03210.jpg'
scale = 16
img_a = shrink_then_quanitize(input_path, 8, 16)
img_b = quantize_then_shrink(input_path, 8, 16) # more jagged, noisy
img_c = pixelate_image(input_path, 8, 16)

img_a.save('lenna-stq2.png')
img_b.save('lenna-qts2.png')
img_c.save('lenna-both2.png')

