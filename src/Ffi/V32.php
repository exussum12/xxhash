<?php
namespace exussum12\xxhash\Ffi;
use FFI;
use exussum12\xxhash\Hash;
/**
 * Class V32
 * This uses the FFI extension which should be much faster than native.
 * @see https://github.com/Cyan4973/xxHash/wiki/xxHash-specification-(draft)
 */
class V32 implements Hash
{
    private int $seed;
    private FFI $ffi;

    public function __construct(int $seed = 0)
    {
        $this->seed = $seed;
        $this->ffi = FFI::cdef(
            '
            typedef uint32_t XXH32_hash_t;
            typedef struct XXH32_state_s XXH32_state_t;
            typedef enum { XXH_OK=0, XXH_ERROR } XXH_errorcode;
            XXH32_hash_t XXH32(
                    const void* input,
                    size_t length,
                    XXH32_hash_t seed
            );
            void XXH32_update(
            XXH32_state_t* state, const void* input, size_t len
            );
            XXH32_state_t* XXH32_createState();
            void XXH32_reset(XXH32_state_t*, XXH32_hash_t);
            XXH32_hash_t XXH32_digest(XXH32_state_t*);
            XXH_errorcode XXH32_freeState(XXH32_state_t* statePtr);
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

        return dechex($this->ffi->XXH32($input, strlen($input), $this->seed));
    }

    public function hashStream($input): string
    {
        if (!isset($this)) {
            $hash = new self();
            return $hash->hashStream($input);
        }

        $state = $this->ffi->XXH32_createState();
        $this->ffi->XXH32_reset($state, $this->seed);

        while (!feof($input)) {
            $buffer = fread($input, 8192);
            $this->ffi->XXH32_update($state, $buffer, strlen($buffer));
        }

        $hash = dechex($this->ffi->XXH32_digest($state));

        $this->ffi->XXH32_freeState($state);
        return $hash;
    }

}
