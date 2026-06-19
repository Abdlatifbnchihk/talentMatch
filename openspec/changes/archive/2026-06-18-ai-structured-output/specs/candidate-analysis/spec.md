## MODIFIED Requirements

### Requirement: CandidateAnalysisService stub
The system SHALL implement `CandidateAnalysisService` to perform real AI-based candidate analysis using the `laravel/ai` SDK, returning an `AnalysisData` DTO.

#### Scenario: Service returns AnalysisData
- **WHEN** CandidateAnalysisService->analyze() is called with a Candidate
- **THEN** system builds a prompt from the candidate's job offer and cv_text, calls `claude-sonnet-4-6` with CandidateAnalysisSchema, and returns an AnalysisData DTO

#### Scenario: Service returns null on failure
- **WHEN** AI call fails or returns invalid data
- **THEN** system logs the error and returns null
