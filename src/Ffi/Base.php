<?php
namespace exussum12\xxhash\Ffi;

use FFI;
use exussum12\xxhash\Hash;

/**
 * Abstract Class Base
 * This uses the FFI extension which should be much faster than native.
 * @see https://github.com/Cyan4973/xxHash/wiki/xxHash-specification-(draft)
 */
abstract class Base implements Hash
{
    protected int $seed;
    protected FFI $ffi;

    //functions from below
    protected string $hash = '';
    protected string $createState = '';
    protected string $reset = '';
    protected string $update = '';
    protected string $digest = '';
    protected string $freeState = '';
    protected string $toHash = '';

    public function hash(string $input): string
    {
        if (!isset($this)) {
            $hash = new static();
            return $hash->hash($input);
        }

        $output = $this->ffi->{$this->hash}($input, strlen($input), $this->seed);
        $hash = $this->ffi->new('XXH128_canonical_t');
        $this->ffi->{$this->toHash}(FFI::addr($hash), $output);
        var_dump(FFI::cast('char*', $hash->digest));
        die();
        return $this->hash;
    }

    public function hashStream($input): string
    {
        if (!isset($this)) {
            $hash = new static();
            return $hash->hashStream($input);
        }

        $state = $this->ffi->{$this->createState}();
        $this->ffi->{$this->reset}($state, $this->seed);

        while (!feof($input)) {
            $buffer = fread($input, 8192);
            $this->ffi->{$this->update}($state, $buffer, strlen($buffer));
        }
        $hash = '';

        $this->ffi->{$this->toHash}($hash, $this->ffi->{$this->digest}($state));

        $this->ffi->{$this->freeState}($state);
        return $hash;
    }
}
