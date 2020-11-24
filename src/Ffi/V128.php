<?php
namespace exussum12\xxhash\Ffi;

use FFI;

/**
 * Class V128
 * This uses the FFI extension which should be much faster than native.
 * @see https://github.com/Cyan4973/xxHash/wiki/xxHash-specification-(draft)
 */
final class V128 extends Base
{
    protected string $hash = 'XXH128';
    protected string $createState = 'XXH3_createState';
    protected string $reset = 'XXH3_128bits_reset';
    protected string $update = 'XXH3_128bits_update';
    protected string $digest = 'XXH3_128bits_digest';
    protected string $freeState = 'XXH3_128bits_digest';

    public function __construct(int $seed = 0)
    {
        $this->seed = $seed;
        $this->ffi = FFI::cdef(
            file_get_contents(__DIR__ . '/Headers/XXH128.h'),
            __DIR__ . '/libxxhash.so.0.7.4'
        );
    }
}
