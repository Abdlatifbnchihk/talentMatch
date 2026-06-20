### Requirement: Conversation creation
The system SHALL create a conversation record when a user starts a chat about a candidate. A conversation SHALL belong to exactly one candidate and one user.

#### Scenario: Create conversation for a candidate
- **WHEN** a user initiates a chat about candidate 5
- **THEN** a `conversations` row is created with `candidate_id = 5` and `user_id` set to the authenticated user, and `title` is nullable

### Requirement: Message storage
The system SHALL persist each message in the `messages` table with a role, content, and optional tool calls. Messages SHALL be immutable (no `updated_at` column).

#### Scenario: Store a user message
- **WHEN** a user sends "Why was this candidate rejected?"
- **THEN** a `messages` row is created with `conversation_id` matching the active conversation, `role = 'user'`, `content = 'Why was this candidate rejected?'`, and `tool_calls = null`

#### Scenario: Store an assistant message
- **WHEN** the AI responds with analysis details
- **THEN** a `messages` row is created with `role = 'assistant'`, `content` containing the response text, and `tool_calls` is `null` or a JSON array if tools were invoked

#### Scenario: Store a tool message
- **WHEN** the AI invokes a tool during response generation
- **THEN** a `messages` row is created with `role = 'tool'`, `content` containing the tool result, and `tool_calls` containing the tool invocation data as a JSON array

### Requirement: Conversation message retrieval
The system SHALL retrieve all messages for a conversation ordered by `created_at` ascending.

#### Scenario: List messages for a conversation
- **WHEN** a user opens an existing conversation with 5 messages
- **THEN** all 5 messages are returned in chronological order

### Requirement: Candidate conversation retrieval
The system SHALL retrieve all conversations for a candidate.

#### Scenario: List conversations for a candidate
- **WHEN** a user views candidate 5's chat history
- **THEN** all conversations where `candidate_id = 5` and `user_id` matches the authenticated user are returned

### Requirement: MessageRole enum
The system SHALL use `App\Enums\MessageRole` enum to cast the `role` column. The enum SHALL have three values: `User` (backed by `'user'`), `Assistant` (backed by `'assistant'`), and `Tool` (backed by `'tool'`).

#### Scenario: Role enum values
- **WHEN** a message is created with role `'assistant'`
- **THEN** `$message->role` returns `MessageRole::Assistant`

### Requirement: Cascade delete
The system SHALL delete all associated conversations when a candidate is deleted, and all associated messages when a conversation is deleted.

#### Scenario: Delete candidate cascades
- **WHEN** candidate 5 with 2 conversations is deleted
- **THEN** both conversations and all their messages are removed from the database
