## 1. Enum and Models

- [x] 1.1 Create `App\Enums\MessageRole` enum with `User = 'user'`, `Assistant = 'assistant'`, `Tool = 'tool'`
- [x] 1.2 Create `Conversation` model with fillable `candidate_id`, `user_id`, `title`; casts; `belongsTo Candidate`, `belongsTo User`, `hasMany Message`
- [x] 1.3 Create `Message` model with fillable `conversation_id`, `role`, `content`, `tool_calls`; casts `role` to `MessageRole` and `tool_calls` to `array`; `belongsTo Conversation`; no `updated_at`
- [x] 1.4 Add `hasMany Conversation` relationship to `Candidate` model
- [x] 1.5 Add `hasMany Conversation` relationship to `User` model

## 2. Migrations

- [x] 2.1 Create `conversations` migration: `id`, `candidate_id` FK (cascade delete), `user_id` FK, `title` nullable string, `timestamps`; indexes on `candidate_id` and `user_id`
- [x] 2.2 Create `messages` migration: `id`, `conversation_id` FK (cascade delete), `role` string, `content` text, `tool_calls` JSON nullable, `created_at` only (no `updated_at`); index on `conversation_id`
- [x] 2.3 Run migrations and verify tables created

## 3. Verification

- [x] 3.1 Verify `MessageRole` enum values match spec (`user`, `assistant`, `tool`)
- [x] 3.2 Verify `Conversation` model relations work (create conversation, access `->candidate`, `->user`, `->messages`)
- [x] 3.3 Verify `Message` model casts `role` to `MessageRole` and `tool_calls` to array
- [x] 3.4 Verify cascade delete: deleting a candidate removes conversations and messages
