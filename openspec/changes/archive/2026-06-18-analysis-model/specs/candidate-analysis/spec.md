## ADDED Requirements

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