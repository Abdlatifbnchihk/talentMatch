## Purpose

Structured AI analysis storage for candidates. Stores extracted skills, experience, education, languages, matching score, strengths, gaps, missing skills, recommendation, and justification after CV analysis.

## Requirements

### Requirement: Analysis storage
The system SHALL store structured AI analysis results for candidates in an `analyses` table.

#### Scenario: Analysis record creation
- **WHEN** AI analysis completes for a candidate
- **THEN** system creates an analysis record with all required fields (extracted_skills, years_experience, education_level, languages, matching_score, strengths, gaps, missing_skills, recommendation, justification)

#### Scenario: Analysis belongs to candidate
- **WHEN** an analysis record is created
- **THEN** it is linked to a specific candidate via candidate_id foreign key

### Requirement: Analysis data structure
The system SHALL store analysis data with the correct types and constraints.

#### Scenario: JSON array fields
- **WHEN** extracted_skills, languages, strengths, gaps, or missing_skills are stored
- **THEN** system stores them as JSON arrays that decode to PHP arrays on retrieval

#### Scenario: Integer fields
- **WHEN** years_experience or matching_score are stored
- **THEN** system stores them as integers (matching_score constrained to 0-100)

#### Scenario: Enum field
- **WHEN** recommendation is stored
- **THEN** system stores it as a string value from the Recommendation enum (convoquer, attente, rejeter)

### Requirement: Recommendation enum
The system SHALL provide a typed enum for analysis recommendations with helper methods.

#### Scenario: Enum values
- **WHEN** a recommendation is created
- **THEN** it must be one of: convoquer (invite to interview), attente (on hold), rejeter (reject)

#### Scenario: Label helper
- **WHEN** code calls `$recommendation->label()`
- **THEN** system returns the human-readable label ("Invite to interview", "On hold", "Reject")

#### Scenario: Badge color helper
- **WHEN** code calls `$recommendation->badgeColor()`
- **THEN** system returns the Tailwind CSS color class ("green", "amber", or "red")

### Requirement: Database indexes
The system SHALL index the analyses table for common query patterns.

#### Scenario: Matching score index
- **WHEN** queries filter or sort by matching_score
- **THEN** system uses the index on matching_score column

#### Scenario: Recommendation index
- **WHEN** queries filter by recommendation
- **THEN** system uses the index on recommendation column

#### Scenario: Unique candidate index
- **WHEN** an analysis is created for a candidate
- **THEN** system enforces one analysis per candidate via unique index on candidate_id

### Requirement: Candidate-Analysis relationship
The system SHALL establish a one-to-many relationship between Candidate and Analysis.

#### Scenario: Candidate has many analyses
- **WHEN** code accesses `$candidate->analyses`
- **THEN** system returns a collection of all analysis records for that candidate

#### Scenario: Analysis belongs to candidate
- **WHEN** code accesses `$analysis->candidate`
- **THEN** system returns the parent candidate model

#### Scenario: Cascade delete
- **WHEN** a candidate is deleted
- **THEN** all associated analysis records are also deleted

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
The system SHALL implement `CandidateAnalysisService` to perform real AI-based candidate analysis using the `laravel/ai` SDK, returning an `AnalysisData` DTO.

#### Scenario: Service returns AnalysisData
- **WHEN** CandidateAnalysisService->analyze() is called with a Candidate
- **THEN** system builds a prompt from the candidate's job offer and cv_text, calls `claude-sonnet-4-6` with CandidateAnalysisSchema, and returns an AnalysisData DTO

#### Scenario: Service returns null on failure
- **WHEN** AI call fails or returns invalid data
- **THEN** system logs the error and returns null

### Requirement: Analysis detail view
The system SHALL display a detailed analysis view for a candidate at GET /offers/{offer}/candidates/{candidate}.

#### Scenario: Pending analysis view
- **WHEN** candidate status is `pending`
- **THEN** system displays "Analysis in progress…" message with meta refresh every 5 seconds

#### Scenario: Analyzed candidate view
- **WHEN** candidate status is `analyzed`
- **THEN** system displays full analysis with score widget, recommendation, strengths, gaps, missing skills, justification, and sidebar details

### Requirement: Score widget
The system SHALL display a large badge showing matching_score out of 100 with color coding.

#### Scenario: High score
- **WHEN** matching_score is ≥ 70
- **THEN** system displays score badge in green

#### Scenario: Medium score
- **WHEN** matching_score is between 40 and 69
- **THEN** system displays score badge in amber

#### Scenario: Low score
- **WHEN** matching_score is < 40
- **THEN** system displays score badge in red

### Requirement: Recommendation pill
The system SHALL display a recommendation pill using the Recommendation enum helpers.

#### Scenario: Display recommendation
- **WHEN** analysis has a recommendation
- **THEN** system displays pill with `badgeColor()` class and `label()` text

### Requirement: Three-column analysis layout
The system SHALL display strengths, gaps, and missing skills in a three-column grid.

#### Scenario: Strengths column
- **WHEN** analysis has strengths
- **THEN** system displays strengths list with checkmark icon

#### Scenario: Gaps column
- **WHEN** analysis has gaps
- **THEN** system displays gaps list with warning icon

#### Scenario: Missing skills column
- **WHEN** analysis has missing_skills
- **THEN** system displays missing skills as pill tags

### Requirement: Justification block
The system SHALL display the full justification text.

#### Scenario: Show justification
- **WHEN** analysis has justification
- **THEN** system displays full paragraph text

### Requirement: Sidebar details
The system SHALL display analysis metadata in a sidebar.

#### Scenario: Sidebar content
- **WHEN** analysis is displayed
- **THEN** system shows years_experience, education_level, extracted_skills (pills), and languages

### Requirement: Chat CTA button
The system SHALL display a call-to-action button for chat assistant.

#### Scenario: CTA link
- **WHEN** analysis view is rendered
- **THEN** system displays "Open chat assistant" button linking to /candidates/{candidate}/chat