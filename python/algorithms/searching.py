import random


def random_list(len_min, len_max, val_min, val_max):
    n = random.randint(len_min, len_max)
    r = []
    for i in range(n):
        v = random.randint(val_min, val_max)
        r.append(v)
    return r


def linear_search(x, e):
    for i in range(len(x)):
        if x[i] == e:
            return i


def binary_search(x, e):
    low = 0
    high = len(x)-1
    while low <= high:
        mid = (low+high)//2
        if x[mid] == e:
            return mid
        elif x[mid] < e:
            low = mid+1
        else:
            high = mid-1
    return None


def main():
    x = random_list(50, 100, 100, 999)
    x = list(sorted(set(x)))
    print(x)
    for i in range(10):
        index = random.randint(0, len(x)-1)
        value = x[index]
        found_index = binary_search(x, value)
        print('index:       ' + str(index))
        print('found index: ' + str(found_index))
        print()

if __name__ == '__main__':
    main()



