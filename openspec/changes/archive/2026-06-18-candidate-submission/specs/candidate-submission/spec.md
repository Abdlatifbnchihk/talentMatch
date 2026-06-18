## ADDED Requirements

### Requirement: Candidate submission form
The system SHALL display a form for candidates to submit their CV for a specific job offer.

#### Scenario: View submission form
- **WHEN** candidate navigates to the submission form for a job offer
- **THEN** system displays a form with name field and CV text area

#### Scenario: Form validation errors
- **WHEN** candidate submits the form with invalid data
- **THEN** system displays validation errors and preserves input

### Requirement: Candidate submission
The system SHALL allow candidates to submit their CV for a job offer with validation.

#### Scenario: Successful submission
- **WHEN** candidate submits valid name and CV text (minimum 50 characters)
- **THEN** system creates a candidate record with status "pending" and redirects to offer page with success message

#### Scenario: Invalid submission
- **WHEN** candidate submits invalid data (missing name, short CV, etc.)
- **THEN** system displays validation errors and returns to form

### Requirement: Candidate status tracking
The system SHALL track candidate submission status with enum values.

#### Scenario: Default status
- **WHEN** candidate is created
- **THEN** its status defaults to "pending"

#### Scenario: Status transition
- **WHEN** candidate is analyzed
- **THEN** status changes to "analyzed"

### Requirement: Background analysis dispatch
The system SHALL dispatch a background job for CV analysis after submission.

#### Scenario: Job dispatch on submission
- **WHEN** candidate successfully submits CV
- **THEN** system dispatches AnalyzeCandidateJob for the candidate