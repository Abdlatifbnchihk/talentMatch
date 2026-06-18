## ADDED Requirements

### Requirement: Async analysis via queue job
The system SHALL dispatch an `AnalyzeCandidateJob` to the `ai-analysis` queue when a new candidate is created.

#### Scenario: Job dispatched on candidate creation
- **WHEN** a candidate is successfully stored via CandidateController@store
- **THEN** system dispatches `AnalyzeCandidateJob` with the newly created candidate

#### Scenario: Job queued on ai-analysis queue
- **WHEN** `AnalyzeCandidateJob` is dispatched
- **THEN** system places the job on the `ai-analysis` queue

#### Scenario: Job retry configuration
- **WHEN** `AnalyzeCandidateJob` is created
- **THEN** system sets retries to 2 and timeout to 90 seconds

### Requirement: Job execution flow
The system SHALL execute analysis steps in order and handle failures gracefully.

#### Scenario: Successful analysis
- **WHEN** `AnalyzeCandidateJob` handle() executes and CandidateAnalysisService returns a non-null result
- **THEN** system creates an Analysis record linked to the candidate and updates candidate status to `analyzed`

#### Scenario: Analysis service returns null
- **WHEN** `AnalyzeCandidateJob` handle() executes and CandidateAnalysisService returns null
- **THEN** system logs the error, keeps candidate status as `pending`, and fails the job

#### Scenario: Analysis throws exception
- **WHEN** `AnalyzeCandidateJob` handle() throws an exception
- **THEN** system logs the error, keeps candidate status as `pending`, and fails the job for retry

### Requirement: CandidateAnalysisService stub
The system SHALL provide a CandidateAnalysisService class that returns null for now.

#### Scenario: Service returns null
- **WHEN** CandidateAnalysisService->analyze() is called with a Candidate
- **THEN** system returns null (stub implementation)
