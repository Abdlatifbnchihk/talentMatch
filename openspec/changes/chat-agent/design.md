## Context

TalentMatch has conversation/message persistence (`conversation-persistence` change) and three AI tools (`agent-tools` change). The chat agent wires these together: a controller receives user messages, persists them, calls the AI agent with full conversation history and tools, and returns the AI reply. The `laravel/ai` SDK is already installed (Groq provider with `llama-3.3-70b-versatile`).

## Goals / Non-Goals

**Goals:**
- Provide a chat UI for HR agents to converse with the AI about a candidate
- Use full conversation history so the AI has context
- Enable tool calling so the AI fetches real data (not hallucinated)
- Submit messages via fetch API (no page reload, smooth UX)

**Non-Goals:**
- Multi-user real-time chat (WebSocket) — single-user per conversation
- Streaming responses — synchronous for simplicity
- Chat history across candidates — each candidate gets its own conversation

## Decisions

**1. One conversation per candidate per user (getOrCreate pattern) over creating new conversations each time**
- Rationale: The `conversation-persistence` spec already defines this. A user asking follow-up questions about the same candidate expects the AI to remember prior context in the same conversation.

**2. Store full conversation history in the messages table, rebuild messages array on each request over in-memory context**
- Rationale: Persisted messages survive page refreshes and server restarts. The AI agent needs the full history for context. Building the array from DB on each request is simple and correct.

**3. Use `laravel/ai` `StructuredAnonymousAgent` with tools over raw HTTP calls**
- Rationale: The SDK handles tool calling lifecycle (invoke tool → get result → re-prompt). Raw HTTP would require implementing the tool-calling loop manually. The SDK's `prompt()` method on agents with tools handles this automatically.

**4. Return JSON from `message` action over redirect**
- Rationale: The frontend uses fetch() for submission. JSON response lets the JS append the reply to the DOM without page reload. The `show` action still returns a full Blade view for initial page load.

**5. System prompt in English, but instruct AI to match user's language**
- Rationale: Tool schemas and AI reasoning work best in English. The instruction "respond in the same language as the HR agent" handles multilingual users naturally.

## Risks / Trade-offs

- **Risk**: Long conversations may exceed model context window → **Mitigation**: Limit to last N messages or truncate old ones (future enhancement)
- **Risk**: Tool calling adds latency (multiple round trips) → **Mitigation**: Timeout set on agent; Groq is fast
- **Risk**: Concurrent messages to same conversation → **Mitigation**: Single-user per conversation, not a concern at current scale
