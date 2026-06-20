## Context

TalentMatch has AI-powered candidate analysis (Groq API) and conversation persistence. The chat assistant needs structured access to data during conversations. The `laravel/ai` SDK provides a `Tool` interface that enables function calling — the AI can invoke PHP tools mid-conversation to fetch real data.

## Goals / Non-Goals

**Goals:**
- Give the AI agent structured read access to candidate analyses, job requirements, and comparison data
- Follow `Laravel\Ai\Contracts\Tool` interface for SDK compatibility
- Return typed, structured data the AI can reason about

**Non-Goals:**
- Write/mutation tools (create, update, delete) — read-only for now
- Authentication/authorization beyond the authenticated user scope (tools run server-side within user context)
- Caching — tools are simple query wrappers; Eloquent eager-loading handles performance

## Decisions

**1. Each tool in its own file under `app/AI/Tools/` over a single Tools class**
- Rationale: Follows Laravel conventions (one class per file), easier to test, discoverable via namespace. The SDK resolves tools by class reference.

**2. Return arrays/JSON strings over Tool-specific response objects**
- Rationale: The `handle()` method returns `Stringable|string`. Returning `json_encode()` of structured data is the standard pattern for the SDK. The AI receives clean JSON it can reason about.

**3. Validate existence in `handle()` and return error message string over throwing exceptions**
- Rationale: Throwing exceptions from tools causes the SDK to treat the tool call as failed. Returning a descriptive error string lets the AI explain the issue to the user gracefully.

**4. Use `schema()` with `JsonSchema` fluent API for parameter definitions**
- Rationale: The SDK uses the schema to tell the AI what parameters are available. The fluent API (`$schema->object([...])`) is the established pattern in the codebase.

## Risks / Trade-offs

- **Risk**: AI calls tools with invalid IDs → **Mitigation**: Return clear error message string, not exception
- **Risk**: Compare tool called with same candidate twice → **Mitigation**: Validated in handle(), return error
- **Risk**: Large skill arrays in responses → **Mitigation**: Not a concern at current scale
