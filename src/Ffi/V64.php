<?php
namespace exussum12\xxhash\Ffi;
use FFI;
use exussum12\xxhash\Hash;
/**
 * Class V64
 * This uses the FFI extension which should be much faster than native.
 * @see https://github.com/Cyan4973/xxHash/wiki/xxHash-specification-(draft)
 */
class V64 implements Hash
{
    private int $seed;
    private FFI $ffi;

    public function __construct(int $seed = 0)
    {
        $this->seed = $seed;
        $this->ffi = FFI::cdef(
            '
            typedef uint64_t XXH64_hash_t;
            typedef struct XXH64_state_s XXH64_state_t;
            typedef enum { XXH_OK=0, XXH_ERROR } XXH_errorcode;
            XXH64_hash_t XXH64(
                    const void* input,
                    size_t length,
                    XXH64_hash_t seed
            );
            void XXH64_update(
            XXH64_state_t* state, const void* input, size_t len
            );
            XXH64_state_t* XXH64_createState();
            void XXH64_reset(XXH64_state_t*, XXH64_hash_t);
            XXH64_hash_t XXH64_digest(XXH64_state_t*);
            XXH_errorcode XXH64_freeState(XXH64_state_t* statePtr);
            ',
            __DIR__ . '/libxxhash.so.0.7.4'
        );
    }
    public function hash(string $input): string
    {
        if (!isset($this)) {
            $hash = new self();
            return $hash->hash($input);
        }

        return dechex($this->ffi->XXH64($input, strlen($input), $this->seed));
    }

    public function hashStream($input): string
    {
        if (!isset($this)) {
            $hash = new self();
            return $hash->hashStream($input);
        }

        $state = $this->ffi->XXH64_createState();
        $this->ffi->XXH64_reset($state, $this->seed);

        while (!feof($input)) {
            $buffer = fread($input, 8192);
            $this->ffi->XXH64_update($state, $buffer, strlen($buffer));
        }

        $hash = dechex($this->ffi->XXH64_digest($state));

        $this->ffi->XXH64_freeState($state);
        return $hash;
    }

}
