## ADDED Requirements

### Requirement: Job offer creation
The system SHALL allow authenticated users to create new job offers with title, description, required skills, and minimum experience years.

#### Scenario: Successful job offer creation
- **WHEN** user submits a valid job offer form with title, description, at least one skill, and experience years
- **THEN** system creates a new job offer record with status "active" and redirects to the offer detail page

#### Scenario: Validation failure on creation
- **WHEN** user submits a job offer form with missing required fields or invalid data
- **THEN** system displays validation errors and returns to the creation form with input preserved

### Requirement: Job offer listing
The system SHALL display a paginated list of the authenticated user's job offers with title, candidate count, and status badge.

#### Scenario: View job offers list
- **WHEN** user navigates to the job offers index page
- **THEN** system displays a table of the user's job offers showing title, candidate count, status badge (active/closed), and action buttons

#### Scenario: Empty job offers list
- **WHEN** user has no job offers
- **THEN** system displays an appropriate empty state message

### Requirement: Job offer detail view
The system SHALL display job offer details including a list of candidates ordered by matching score.

#### Scenario: View job offer details
- **WHEN** user clicks on a job offer to view details
- **THEN** system displays offer title, description, required skills, experience requirement, status, and a table of candidates sorted by matching_score descending with eager-loaded analysis

### Requirement: Job offer update
The system SHALL allow users to edit their existing job offers and optionally change status.

#### Scenario: Update job offer details
- **WHEN** user submits valid changes to a job offer
- **THEN** system updates the offer and redirects to the detail page

#### Scenario: Change job offer status
- **WHEN** user changes the status field to "active" or "closed"
- **THEN** system updates the offer status accordingly

### Requirement: Job offer deletion
The system SHALL allow users to delete their job offers with confirmation.

#### Scenario: Delete job offer
- **WHEN** user confirms deletion of a job offer
- **THEN** system removes the offer and redirects to the offers list

### Requirement: Data isolation by user
The system SHALL ensure users can only access and modify their own job offers.

#### Scenario: Access control on job offers
- **WHEN** user attempts to view, edit, or delete a job offer
- **THEN** system verifies the offer belongs to the authenticated user and denies access if not

### Requirement: Job offer status enum
The system SHALL use a typed enum for job offer status with values "active" and "closed".

#### Scenario: Status enum values
- **WHEN** a job offer is created
- **THEN** its status defaults to "active"

#### Scenario: Status transitions
- **WHEN** user changes status from "active" to "closed" or vice versa
- **THEN** system accepts the transition and updates the record
