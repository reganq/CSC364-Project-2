### Bug1 - memcpy heap overflow
- Category: heap overflow
- Trigger: Decoding an input with a first byte that has a larger value than 32 (i.e. the max length for a record name).
- Root cause: decode_record treats the first byte of input as the length of the record's name. Records have a fixed name length (specifically, 32 bytes). If the given length is longer than 32 (MAX_NAME), the memcpy at line 32 will overflow the heap, reading as many bytes are specified.
- Fix: The fix for this bug is to check the value of name_len, and make sure that it is no longer than MAX_NAME. This ensures that the memcpy cannot overflow the heap.

### Bug2 - input size checking
- Category: heap overflow
- Trigger: Trying to read more bytes than were allocated for the buffer at the first memcpy.
- Root cause: The len field input for decode_record is never checked, so it is possible that memory that is too small has been input. For example, the crashing bug has a memory segment that is only one byte, meaning memcpy fails when copying from the buffer since the memory wasn't allocated.
- Fix: Add a size check before accessing the buffer to ensure that it has enough memory to proceed. If not, return 0 (i.e meaning that the record was not decoded).