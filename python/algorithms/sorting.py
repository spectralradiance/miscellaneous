
import random


# generate a random list of n values each between 1 and 99
def random_list(n):
    nums = []
    for i in range(n):
        nums.append(random.randint(1, 99))
    return nums


# re-arrange a list by swapping pairs of elements
def shuffle(nums):
    for i in range(len(nums)):
        j = random.randint(0, len(nums) - 1)  # pick a random index
        nums[i], nums[j] = nums[j], nums[i] # swap!


# check if a list is sorted, look at individual pairs
def is_sorted(nums):
    for i in range(len(nums) - 1):
        if nums[i] > nums[i + 1]:
            return False
    return True


def bogosort(nums):
    while not is_sorted(nums):  # loop until the list is sorted
        shuffle(nums)
        print(nums)


def main():
    nums = random_list(5)
    print(nums)
    bogosort(nums)
    print(nums)


if __name__ == '__main__':
    main()

