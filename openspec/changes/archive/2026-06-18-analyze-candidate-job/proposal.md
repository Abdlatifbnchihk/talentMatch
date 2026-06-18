## Why

Candidate analysis is currently not triggered asynchronously. When a candidate is submitted, the analysis needs to happen in the background to avoid blocking the HTTP request and to handle AI service latency/retries gracefully.

## What Changes

- New `AnalyzeCandidateJob` queue job class that processes candidate analysis asynchronously
- CandidateController@store updated to dispatch the job after candidate creation
- Queue configuration: `QUEUE_CONNECTION=redis` in `.env.example`, `ai-analysis` queue added to worker config

## Capabilities

### New Capabilities

(none)

### Modified Capabilities

- `candidate-analysis`: Adding async job dispatch for AI analysis (new requirement: analysis triggered via queue job, not synchronous)

## Impact

- New file: `app/Jobs/AnalyzeCandidateJob.php`
- Modified: `app/Http/Controllers/CandidateController.php` (store method)
- Modified: `.env.example` (queue connection)
- Modified: Queue worker configuration
