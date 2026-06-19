## Context

TalentMatch has a working candidate analysis pipeline: `CandidateController@store` dispatches `AnalyzeCandidateJob` to the `ai-analysis` queue, which calls `CandidateAnalysisService` and persists results to the `analyses` table. However, the service is a stub returning null. The `laravel/ai` SDK is not yet installed. The `Analysis` model, `Recommendation` enum, and database schema are all in place.

## Goals / Non-Goals

**Goals:**
- Install `laravel/ai` SDK and configure it for Claude Sonnet
- Create a typed `AnalysisData` DTO with `fromArray()` constructor
- Define a `CandidateAnalysisSchema` for structured JSON output
- Implement `CandidateAnalysisService` to build prompts, call AI, and return DTO
- Update `AnalyzeCandidateJob` to persist DTO data to `Analysis` model

**Non-Goals:**
- Streaming or real-time analysis UI
- Multi-model fallback logic
- Prompt versioning or A/B testing
- Caching analysis results

## Decisions

- **DTO pattern over raw arrays**: Type safety, IDE support, and explicit contract between AI output and database. Alternative: pass arrays directly (rejected — no compile-time checks).
- **laravel/ai SDK**: Official Laravel package with structured output support via schemas. Alternative: raw HTTP to Anthropic API (rejected — more boilerplate, no schema enforcement).
- **Claude Sonnet model**: Best balance of quality and speed for structured extraction tasks. Alternative: GPT-4o (rejected — vendor preference).
- **Schema in dedicated class**: Separates schema definition from service logic, allows reuse and testing. Alternative: inline schema in service (rejected — violates SRP).
- **Service returns DTO, job persists**: Clean separation — service handles AI interaction, job handles persistence and status updates.

## Risks / Trade-offs

- [AI service unavailable] → Job retries (2 attempts) handle transient failures; permanent failures logged and job failed
- [Malformed AI response] → Schema enforcement catches type mismatches; null/missing fields handled with defaults in DTO
- [API cost] → Each candidate analysis is one API call; timeout at 90s prevents runaway costs
- [laravel/ai version compatibility] → Pin to stable release, test with Laravel 13
