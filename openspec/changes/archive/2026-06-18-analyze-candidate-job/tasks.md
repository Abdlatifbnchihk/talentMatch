## 1. Service Stub

- [x] 1.1 Create `app/Services/CandidateAnalysisService.php` with `analyze(Candidate $candidate): ?array` method returning null

## 2. Job Implementation

- [x] 2.1 Update `app/Jobs/AnalyzeCandidateJob.php`: add `$tries = 2`, `$timeout = 90`, `$queue = 'ai-analysis'`
- [x] 2.2 Implement `handle()` to load candidate with jobOffer, call CandidateAnalysisService, create Analysis on success, update status to `analyzed`
- [x] 2.3 Add exception handling: log error, keep status `pending`, fail job

## 3. Queue Configuration

- [x] 3.1 Create `.env.example` with `QUEUE_CONNECTION=redis`
- [x] 3.2 Add `ai-analysis` to queue worker configuration

## 4. Verification

- [x] 4.1 Verify `CandidateController@store` dispatches AnalyzeCandidateJob (already in place)
- [x] 4.2 Run lint/typecheck if available
