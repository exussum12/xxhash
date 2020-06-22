typedef uint64_t XXH64_hash_t;
typedef struct XXH64_state_s XXH64_state_t;
typedef enum { XXH_OK=0, XXH_ERROR } XXH_errorcode;
XXH64_hash_t XXH64(
        const void* input,
        size_t length,
        XXH64_hash_t seed
);
void XXH64_update(
    XXH64_state_t* state,
    const void* input,
    size_t len
);
XXH64_state_t* XXH64_createState();
void XXH64_reset(XXH64_state_t*, XXH64_hash_t);
XXH64_hash_t XXH64_digest(XXH64_state_t*);
XXH_errorcode XXH64_freeState(XXH64_state_t* statePtr);
