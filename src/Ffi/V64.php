<?php
namespace exussum12\xxhash\Ffi;

use FFI;

/**
 * Class V64
 * This uses the FFI extension which should be much faster than native.
 * @see https://github.com/Cyan4973/xxHash/wiki/xxHash-specification-(draft)
 */
final class V64 extends Base
{
    protected string $hash = 'XXH64';
    protected string $createState = 'XXH64_createState';
    protected string $reset = 'XXH64_reset';
    protected string $update = 'XXH64_update';
    protected string $digest = 'XXH64_digest';
    protected string $freeState = 'XXH64_digest';

    public function __construct(int $seed = 0)
    {
        $this->seed = $seed;
        $this->ffi = FFI::cdef(
            file_get_contents(__DIR__ . '/Headers/XXH64.h'),
            __DIR__ . '/libxxhash.so.0.7.4'
        );
    }
}
