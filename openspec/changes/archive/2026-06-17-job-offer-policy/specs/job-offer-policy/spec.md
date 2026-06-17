## ADDED Requirements

### Requirement: Job offer view authorization
The system SHALL allow only the owner of a job offer to view its details.

#### Scenario: Owner views own offer
- **WHEN** authenticated user attempts to view a job offer they own
- **THEN** system displays the offer details

#### Scenario: Non-owner views offer
- **WHEN** authenticated user attempts to view a job offer they do not own
- **THEN** system returns 403 forbidden response

### Requirement: Job offer update authorization
The system SHALL allow only the owner of a job offer to update it.

#### Scenario: Owner updates own offer
- **WHEN** authenticated user attempts to update a job offer they own
- **THEN** system allows the update operation

#### Scenario: Non-owner updates offer
- **WHEN** authenticated user attempts to update a job offer they do not own
- **THEN** system returns 403 forbidden response

### Requirement: Job offer deletion authorization
The system SHALL allow only the owner of a job offer to delete it.

#### Scenario: Owner deletes own offer
- **WHEN** authenticated user attempts to delete a job offer they own
- **THEN** system allows the deletion

#### Scenario: Non-owner deletes offer
- **WHEN** authenticated user attempts to delete a job offer they do not own
- **THEN** system returns 403 forbidden response