typedef uint32_t XXH32_hash_t;
typedef struct XXH32_state_s XXH32_state_t;
typedef enum { XXH_OK=0, XXH_ERROR } XXH_errorcode;
XXH32_hash_t XXH32(
        const void* input,
        size_t length,
        XXH32_hash_t seed
);
void XXH32_update(
    XXH32_state_t* state,
    const void* input,
    size_t len
);
XXH32_state_t* XXH32_createState();
void XXH32_reset(XXH32_state_t*, XXH32_hash_t);
XXH32_hash_t XXH32_digest(XXH32_state_t*);
XXH_errorcode XXH32_freeState(XXH32_state_t* statePtr);
