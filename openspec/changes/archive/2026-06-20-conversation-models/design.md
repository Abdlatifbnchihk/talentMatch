## Context

TalentMatch is a Laravel 11 candidate-matching platform. We've built AI-powered candidate analysis (Groq API, queue jobs). The next feature is a chat assistant that lets users ask follow-up questions about a candidate's analysis (e.g., "Why were they rejected?", "What skills are missing?"). This requires persisting conversations and messages. Currently, no conversation or message persistence exists.

## Goals / Non-Goals

**Goals:**
- Provide durable storage for user-assistant conversations tied to a candidate
- Support message history with role differentiation (user, assistant, tool)
- Enable future tool-call tracking via `tool_calls` JSON column
- Follow Laravel 11 conventions (casts, relations, migrations)

**Non-Goals:**
- Real-time streaming or WebSocket support (future enhancement)
- Message editing/deletion (messages are immutable)
- Multi-turn context windowing or token management (handled by AI service layer)
- Conversation sharing between users

## Decisions

**1. Separate `conversations` and `messages` tables (normalized) over a single table with nested JSON**
- Rationale: Normalized design supports efficient queries (list conversations, paginate messages), foreign key integrity, and Eloquent relations. A single JSON blob would be simpler but makes querying and pagination difficult.

**2. `MessageRole` as a PHP enum with string backing values (`user`, `assistant`, `tool`) over integer constants or string column without cast**
- Rationale: Enum provides type safety, IDE autocompletion, and self-documenting code. String values (`user`, `assistant`, `tool`) are human-readable in the database and match OpenAI/Groq API conventions.

**3. `messages` table has only `created_at` (no `updated_at`) — messages are immutable**
- Rationale: Chat messages are append-only records. An `updated_at` column would be misleading since messages are never modified after creation.

**4. `tool_calls` as nullable JSON column with array cast over a separate `tool_calls` table**
- Rationale: Tool calls are tightly coupled to a single message and always accessed together. A separate table adds JOIN overhead for no benefit. JSON array is sufficient for the structured data.

**5. `title` nullable on `conversations` — auto-generated from first message or user-provided**
- Rationale: Conversations may not have a meaningful title at creation time. Nullable avoids mandatory title generation logic at conversation creation.

## Risks / Trade-offs

- **Risk**: Orphaned conversations if candidates are deleted → **Mitigation**: Add `cascadeOnDelete` foreign key constraint on `conversations.candidate_id`
- **Risk**: Large message history growing table size → **Mitigation**: Pagination via Eloquent; no concern at current scale
- **Risk**: `tool_calls` JSON column may have inconsistent structure → **Mitigation**: PHP cast to array enforces structure at application level
