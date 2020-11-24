typedef uint64_t XXH64_hash_t;
typedef uint32_t XSUM_U32;
typedef struct {
	    XXH64_hash_t low64;   /*!< `value & 0xFFFFFFFFFFFFFFFF` */
			XXH64_hash_t high64;  /*!< `value >> 64` */
} XXH128_hash_t;

typedef struct XXH128_state_s XXH128_state_t;
typedef enum { XXH_OK=0, XXH_ERROR } XXH_errorcode;
XXH128_hash_t XXH128(
        const void* input,
        size_t length,
        XSUM_U32 seed
);
void XXH3_128bits_update(
    XXH128_state_t* state,
    const void* input,
    size_t len
);
XXH128_state_t* XXH3_createState();
void XXH3_128bits_reset(XXH128_state_t*, XXH128_hash_t);
XXH128_hash_t XXH3_128bits_digest(XXH128_state_t*);
