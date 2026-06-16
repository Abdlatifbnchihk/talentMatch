## ADDED Requirements

### Requirement: Auth views extend main layout
The system SHALL render all authentication views within the existing `layouts/app.blade.php` layout.

#### Scenario: Login view extends layout
- **WHEN** login page is rendered
- **THEN** view extends `layouts/app.blade.php` and displays login form within the layout structure

#### Scenario: Registration view extends layout
- **WHEN** registration page is rendered
- **THEN** view extends `layouts/app.blade.php` and displays registration form within the layout structure

### Requirement: Forms display validation errors
The system SHALL display flash error messages on authentication forms when validation fails.

#### Scenario: Login form displays errors
- **WHEN** login fails with validation errors
- **THEN** login page displays error messages next to relevant form fields

#### Scenario: Registration form displays errors
- **WHEN** registration fails with validation errors
- **THEN** registration page displays error messages next to relevant form fields

### Requirement: Forms have proper input fields
The system SHALL provide all required input fields for each authentication form.

#### Scenario: Login form has required fields
- **WHEN** login page is rendered
- **THEN** form contains email input, password input, remember me checkbox, and submit button

#### Scenario: Registration form has required fields
- **WHEN** registration page is rendered
- **THEN** form contains name input, email input, password input, password confirmation input, and submit button

### Requirement: Forms submit to correct endpoints
The system SHALL configure forms to submit to the appropriate authentication routes.

#### Scenario: Login form submits to POST /login
- **WHEN** user submits login form
- **THEN** form sends POST request to /login endpoint

#### Scenario: Registration form submits to POST /register
- **WHEN** user submits registration form
- **THEN** form sends POST request to /register endpoint
