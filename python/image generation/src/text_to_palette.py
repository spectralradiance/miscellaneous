

import settings
import urllib
from urllib.parse import urlencode
from urllib.request import Request, urlopen
import json
import io

from PIL import Image




pixels = {}
n_images = 0
image_index = 0
errors = []
n_total_pixels = 0
output_width = None
output_height = None
search_text = None



normalized_images = []


def color_distance(a, b):
    r = 0
    for i in range(len(a)):
        diff = a[i] - b[i]
        r += diff*diff
    return r


def process_image(url):

    global n_images, image_index, n_total_pixels, normalized_images, output_width, output_height

    print(f'downloading image {image_index} - {round(image_index/n_images*100, 2)}%')
    print('\turl: '+url)
    image_index += 1

    req = Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        response = urlopen(req)
        file = io.BytesIO(response.read())
        img = Image.open(file)
        img = img.convert('RGB')
    except BaseException as e:
        errors.append((url, str(e)))
        return



    width, height = img.size
    n_total_pixels += width*height
    mp = round(width*height/1000000, 2)

    print(f'\tdownload complete: {img.size}, {mp}mp')

    img_pixels = img.load()
    pixel_weight = 1/(width*height)
    for i in range(width):
        for j in range(height):
            c = img_pixels[i, j]
            if c in pixels:
                pixels[c] += pixel_weight
            else:
                pixels[c] = pixel_weight


    tp = img.resize((output_width, output_height), Image.ANTIALIAS).load()
    normalized_images.append([[tp[i, j] for j in range(output_height)] for i in range(output_width)])





def process_batch(search_text, start_index, n_images):

    query_parameters = {
        'q': search_text,
        'cx': settings.google_custom_search_engine_id,
        'start': start_index,
        'num': n_images,
        'searchType': 'image',
        'key': settings.google_custom_search_api_key
    }
    query_string = urlencode(query_parameters)
    url = 'https://www.googleapis.com/customsearch/v1?' + query_string
    print(f'querying for {n_images} images...')
    print('\t'+url)
    with urllib.request.urlopen(url) as req:
        data = json.loads(req.read().decode())
        for result in data['items']:
            process_image(result['link'])


def process_term(search_text, n_images_total):
    start_index = 1
    while True:
        if n_images_total > 10:
            process_batch(search_text, start_index, 10)
            start_index += 10
            n_images_total -= 10
        else:
            process_batch(search_text, start_index, n_images_total)
            break



def main():




    global n_images, output_width, output_height, search_text, normalized_images


    output_width = 600
    output_height = 600
    n_images = 30
    search_text = 'chaos symbol'

    process_term(search_text, n_images)

    print(f'{len(errors)} errors encountered:')
    for error in errors:
        print('\t'+str(error))
    print(f'processed {n_total_pixels} pixels')
    print(f'accumulated {len(pixels)} colors')

    show_spacial_match()


def show_spacial_match():

    global n_images, output_width, output_height, search_text, normalized_images

    top_colors_limit = 100

    tpixels = list(pixels.items())
    tpixels.sort(key=lambda tup: tup[1], reverse=True)
    tpixels = tpixels[:top_colors_limit]





    output_img = Image.new('RGB', (output_width, output_height))
    output_pixels = output_img.load()
    k = 0
    for i in range(output_width):
        for j in range(output_height):

            # we have two lists of colors:
            #     1. the list of most common colors
            #     2. the colors across all the images at location i, j

            distances = []
            for c in range(len(tpixels)):
                distances.append([0, c])
                for n_img in normalized_images:
                    cimg = n_img[i][j]
                    tp = tpixels[c][0]
                    td = color_distance(cimg, tp)
                    distances[c][0] += td

            distances.sort(key=lambda d: d[0])
            output_pixels[i, j] = tpixels[distances[0][1]][0]


            k += 1

        print(f'{round(k/(output_width*output_height)*100, 2)}%')

    output_scale = 4
    output_img = output_img.resize((output_scale * output_width, output_scale * output_height))
    output_img.save(f'../output/{search_text}-spacial.jpg')
    output_img.show()



def show_most_common():

    global n_images, output_width, output_height, search_text

    tpixels = list(pixels.items())
    tpixels.sort(key=lambda tup: tup[1], reverse=True)
    #for i in range(min(100, len(tpixels))):
    #    print(tpixels[i])

    output_img = Image.new('RGB', (output_width, output_height))
    output_pixels = output_img.load()
    k = 0
    for j in range(output_height):
        for i in range(output_width):
            if k < len(tpixels):
                output_pixels[i, j] = tpixels[k][0]
            else:
                output_pixels[i, j] = (0, 0, 0)
            k += 1

    output_scale = 4
    output_img = output_img.resize((output_scale*output_width, output_scale*output_height))
    output_img.save(f'../output/{search_text}.jpg')
    output_img.show()










main()

