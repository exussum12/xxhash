A pure PHP implementation of [xxhash](https://github.com/Cyan4973/xxHash)

Currently only working for the 32 bit version. (Pre PHP 7.4). 32 and 64 bit version both work with PHP 7.4

If speed is important use the FFI versions (PHP 7.4+)

XXHash is a fast hash designed for file integrity checking. Passwords should not be hashed with this, please use Argon2 or BCrypt.

# Installing

With composer 

    composer require exussum12/xxhash

# Hashing input

xxhash has a seed, this is 0 by default. To make a new instance of xxhash run

    use exussum12\xxhash\V32;
    $seed = 0;
    $hash = new V32($seed);

Then to hash input, run

    $hash->hash('string'); ## to hash a string
 
 or
 
    $file = fopen('path/to/file.ext', 'r');
    $hash->hashStream($file); # for a stream (better for large files)

The library can be called statically also, however this removes the ability to change the seed. The default see of 0 will be used

    V32::hash('string'); ## to hash a string
    $file = fopen('path/to/file.ext', 'r');
    V32::hashStream($file); # for a stream (better for large files)

Static functions should in general be avoided, so the first method is the preferred method to use.

## FFI
Since PHP 7.4 FFI allows PHP to call the native C client. This is much faster, and the preferred way if your running PHP 7.4

### Speed Comparison
This is hashing a 320mb file using the stream method.
The time is the time take (smaller is better)

|Method       |Time  | Peak Memory |
|-------------|------|-------------|
|xxHash Binary| 0.081|       1604kb|
|FFI          | 0.194|      27616kb|
|Pure PHP     |49.218|      27844kb|

Memory measured using `/usr/bin/time -v` 
