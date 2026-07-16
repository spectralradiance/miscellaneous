

# returns true if 'a' is divisiable by 'b'
# the modulus a%b returns the remainder of a/b
# e.g. is_divisible(16,4) would be 'true'
# but is_divisable(17,4) would be 'false' because 17%4 == 1
def is_divisible(a, b):
    return a%b == 0


def is_prime(v):
    for i in range(2, v):  # check all numbers from 2 to v-1
        if is_divisible(v, i):  # if v is divisible by i, v is not prime, return false
            return False
    return True


# The least common multiple (LCM)
# of two numbers is the smallest number (not zero) that is a multiple of both
# the LCM of 3 and 4 is 12
# the LCM of 4 and 10 is 20
# multiples of 4 are 4,8,12,16,20,24,..
# multiples of 10 are 10,20,30,40,...
def least_common_multiple(a, b):
    lb = max(a, b)  # lower-bound, possibly a common divisor
    ub = a*b  # upper-bound, guaranteed to be a common divisor
    for i in range(lb, ub):
        if is_divisible(i, a) and is_divisible(i, b):
            return i
    return ub


# the greatest common divisor (GCD) of two integers
# is the largest positive integer that divides each of the integers
# For example, the gcd of 8 and 12 is 4
def greatest_common_divisor(a, b):
    lb = 1  # lower-bound, the lowest possible GCD
    ub = min(a, b)  # upper-bound, the lower of the two arguments
    for i in range(ub, lb, -1):  # loop backwards, because we're trying to find the highest
        if is_divisible(a, i) and is_divisible(b, i):
            return i
    return 1


# a little helper function to check values for us
def check_values(a, b):
    lcm = least_common_multiple(a, b)
    gcd = greatest_common_divisor(a, b)
    print('lcm('+str(a)+','+str(b)+')='+str(lcm))
    print('gcd('+str(a)+','+str(b)+')='+str(gcd))


if __name__ == '__main__':
    check_values(3, 4)
    check_values(4, 10)
    check_values(8, 12)
