## MODIFIED Requirements

### Requirement: Data isolation by user
The system SHALL ensure users can only access and modify their own job offers using Laravel Policy authorization.

#### Scenario: Access control on job offers
- **WHEN** user attempts to view, edit, or delete a job offer
- **THEN** system uses JobOfferPolicy to verify ownership and denies access with 403 if not authorized