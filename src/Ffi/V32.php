<?php
namespace exussum12\xxhash\Ffi;

use FFI;

/**
 * Class V32
 * This uses the FFI extension which should be much faster than native.
 * @see https://github.com/Cyan4973/xxHash/wiki/xxHash-specification-(draft)
 */
final class V32 extends Base
{
    protected string $hash = 'XXH32';
    protected string $createState = 'XXH32_createState';
    protected string $reset = 'XXH32_reset';
    protected string $update = 'XXH32_update';
    protected string $digest = 'XXH32_digest';
    protected string $freeState = 'XXH32_digest';

    public function __construct(int $seed = 0)
    {
        $this->seed = $seed;
        $this->ffi = FFI::cdef(
            file_get_contents(__DIR__ . '/Headers/XXH32.h'),
            __DIR__ . '/libxxhash.so.0.7.4'
        );
    }
}
