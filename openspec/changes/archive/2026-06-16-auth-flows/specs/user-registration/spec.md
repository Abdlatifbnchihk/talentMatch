## ADDED Requirements

### Requirement: User can register with valid credentials
The system SHALL allow users to create an account by providing name, email, password, and password confirmation.

#### Scenario: Successful registration with valid data
- **WHEN** user submits registration form with valid name, email, password, and matching password confirmation
- **THEN** system creates new user account with hashed password and logs the user in automatically

#### Scenario: Registration fails with duplicate email
- **WHEN** user submits registration form with email that already exists in the system
- **THEN** system returns validation error message "The email has already been taken"

#### Scenario: Registration fails with invalid email format
- **WHEN** user submits registration form with invalid email format
- **THEN** system returns validation error message "The email field must be a valid email address"

#### Scenario: Registration fails with short password
- **WHEN** user submits registration form with password less than 8 characters
- **THEN** system returns validation error message "The password field must be at least 8 characters"

#### Scenario: Registration fails with mismatched passwords
- **WHEN** user submits registration form with password and password_confirmation that don't match
- **THEN** system returns validation error message "The password confirmation does not match"

#### Scenario: Registration fails with missing required fields
- **WHEN** user submits registration form with empty name, email, password, or password_confirmation
- **THEN** system returns validation error message for each missing required field

### Requirement: System hashes passwords securely
The system SHALL hash all user passwords using bcrypt before storing them in the database.

#### Scenario: Password is hashed before storage
- **WHEN** user registers with a password
- **THEN** system stores bcrypt hash of password in database, not the plain text password

### Requirement: User is logged in after registration
The system SHALL automatically log in the user after successful registration.

#### Scenario: Auto-login after registration
- **WHEN** user completes successful registration
- **THEN** system creates session for the user and redirects to home page or intended URL
