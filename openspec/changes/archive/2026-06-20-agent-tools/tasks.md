## 1. Tool Directory Setup

- [x] 1.1 Create `app/AI/Tools/` directory if it doesn't exist

## 2. GetCandidateAnalysisTool

- [x] 2.1 Create `GetCandidateAnalysisTool` class implementing `Laravel\Ai\Contracts\Tool`
- [x] 2.2 Implement `description()` returning tool purpose string
- [x] 2.3 Implement `schema()` defining `candidate_id` integer parameter
- [x] 2.4 Implement `handle()` — fetch candidate with latestAnalysis and jobOffer, return structured array, or error message if not found/not analyzed

## 3. GetJobRequirementsTool

- [x] 3.1 Create `GetJobRequirementsTool` class implementing `Laravel\Ai\Contracts\Tool`
- [x] 3.2 Implement `description()` returning tool purpose string
- [x] 3.3 Implement `schema()` defining `job_offer_id` integer parameter
- [x] 3.4 Implement `handle()` — fetch job offer, return title/description/skills/experience/status, or error message if not found

## 4. CompareCandidatesTool

- [x] 4.1 Create `CompareCandidatesTool` class implementing `Laravel\Ai\Contracts\Tool`
- [x] 4.2 Implement `description()` returning tool purpose string
- [x] 4.3 Implement `schema()` defining `candidate_id_1` and `candidate_id_2` integer parameters
- [x] 4.4 Implement `handle()` — fetch both candidates with analyses, build side-by-side comparison with score_diff and better_candidate, or error message if either not found/not analyzed

## 5. Verification

- [x] 5.1 Verify all three tools implement `Laravel\Ai\Contracts\Tool` interface
- [x] 5.2 Verify tools return correct data by instantiating and calling handle() with test IDs
