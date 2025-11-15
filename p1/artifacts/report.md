### Bug1 - memcpy heap overflow
- Category: Heap overflow
- Trigger: Decoding an input with a first byte that has a larger value than 32 (i.e. the max length for a record name).
- Root cause: decode_record treats the first byte of input as the length of the record's name. Records have a fixed name length (specifically, 32 bytes). If the given length is longer than 32 (MAX_NAME), the memcpy at line 32 will overflow the heap, reading as many bytes are specified.
- Fix: The fix for this bug is to check the value of name_len, and make sure that it is no longer than MAX_NAME. This ensures that the memcpy cannot overflow the heap.

### Bug2 - input size checking
- Category: Heap overflow.
- Trigger: Trying to read more bytes than were allocated for the buffer at the first memcpy.
- Root cause: The len field input for decode_record is never checked, so it is possible that memory that is too small has been input. For example, the crashing bug has a memory segment that is only one byte, meaning memcpy fails when copying from the buffer since the memory wasn't allocated.
- Fix: Add a size check before accessing the buffer to ensure that it has enough memory to proceed. If not, return 0 (i.e meaning that the record was not decoded).

### Bug3 - memory over-request bug
- Category: Out-of-memory error
- Trigger: Allocating memory to to write the scores array into, size requested is too large.
- Root cause: The value of score_count read from buf is larger than the available memory, so when allocating memory for the score array an out-of-memory bug is thrown. 
- Fix: Add in a check before setting score_count, to ensure that it is no larger than the number of bytes remaining to be read (divided by two, as scores are 16-bit integers).

### Bug4 - strlen read overflow
- Category: Read buffer overflow.
- Trigger: Triggered in the first memcpy of encode_record, since name_len may be much larger than the given buffer. Could also trigger an out-of-memory error when allocating space for the buffer.
- Root cause: The strlen call in encode_record will search until it encounters a null terminator, and can return a value much larger than the record if a null terminator is not added to the name.
- Fix: Replacing the strlen call with strnlen ensures that the name length has a maximum size.

### Bug5 - Offset overflow
- Category: Integer overflow
- Trigger: Occurs when a record is passed to encode that requires more space that can be represented by size_t (16 bits unsigned), which could lead to a heap overflow.  Note that this bug could not be triggered by decode, since the length of buffer is passed as a size_t (i.e. must be representable).
- Root cause: Encode stores the size needed to store a record as a size_t. If the given record is too large, then the size variable will overflow causing too little memory to be allocated.
- Fix: Add size checks in encode_record before adding ints to ensure no overflow occurs, and return early if it does.