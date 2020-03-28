A pure PHP implementation of [xxhash](https://github.com/Cyan4973/xxHash)

Currently only working for the 32 bit version.

If speed is important use the php extension instead

# Installing

Ideally use composer 

    composer require exussum12/xxhash

Alternatively require the single file (making sure the path is correct)

    require 'xxhash/V32.php';

# Hashing input

xxhash has a seed, this is 0 by default. To make a new instance of xxhash run

    $seed = 0;
    $hash = new V32($seed);

Then to hash input, run

    $hash->hash('string'); ## to hasha string
    $file = fopen('path/to/file.ext', 'r');
    $hash->hashStream($file); # for a stream (better for large files)

The library can be called statically also, however this removes the ability to change the seed. The default see of 0 will be used

    V32::hash('string'); ## to hasha string
    $file = fopen('path/to/file.ext', 'r');
    V32::hashStream($file); # for a stream (better for large files)

Static functions should in general be avoided so the first method is the preferred method to use.
