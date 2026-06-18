## Context

The TalentMatch application needs to perform AI-based candidate analysis asynchronously. Currently, the `AnalyzeCandidateJob` exists as a stub that only logs a message. The `CandidateController@store` already dispatches the job. The `CandidateAnalysisService` does not exist yet. The candidate status enum has `pending` and `analyzed` states, and the `Analysis` model is ready to store results.

## Goals / Non-Goals

**Goals:**
- Implement `AnalyzeCandidateJob` with proper queue config, retries, and timeout
- Create `CandidateAnalysisService` as a stub returning null (AI integration deferred)
- Handle success: create Analysis record, update candidate status to `analyzed`
- Handle failure: log error, keep status as `pending`, fail job for retry

**Non-Goals:**
- Actual AI service integration (stub only)
- Frontend changes for analysis display
- Database migrations (already exist)

## Decisions

- **Queue name `ai-analysis`**: Isolates AI work from default queue, allows separate worker scaling
- **Redis queue connection**: Required for reliable job persistence and retry support
- **2 retries, 90s timeout**: Balances retry safety against AI service latency
- **Service stub returning null**: Allows testing job flow without AI dependency; real service can be swapped in later
- **Fail job on null/error**: Ensures Laravel's retry mechanism activates on transient failures

## Risks / Trade-offs

- [Stub returns null] → Job will always fail until real service is implemented; acceptable for scaffolding
- [Redis dependency] → Requires Redis server running; mitigated by `.env.example` documenting the requirement
