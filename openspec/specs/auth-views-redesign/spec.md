# Auth Views Redesign

## Purpose

Professional split-screen auth pages for login and registration.

## Requirements

### Requirement: Split-screen auth layout
Auth pages SHALL display a full-screen split layout without navbar or sidebar.

#### Scenario: Left panel
- **WHEN** auth page renders on desktop
- **THEN** left half has indigo-700 bg with white logo, tagline, and feature rows

#### Scenario: Left panel mobile
- **WHEN** auth page renders on mobile
- **THEN** left panel is hidden

#### Scenario: Right panel
- **WHEN** auth page renders
- **THEN** right half has white bg with centered form card

### Requirement: Login form
The login page SHALL display a professional login form.

#### Scenario: Form header
- **WHEN** login form renders
- **THEN** it shows "Welcome back 👋" h2 and "Sign in to your account" subtext

#### Scenario: Email field
- **WHEN** login form renders
- **THEN** email input has envelope icon inside left padding

#### Scenario: Password field
- **WHEN** login form renders
- **THEN** password input has lock icon and eye toggle button

#### Scenario: Remember me and forgot password
- **WHEN** login form renders
- **THEN** "Remember me" checkbox is on left and "Forgot password?" link is on right

#### Scenario: Sign in button
- **WHEN** login form renders
- **THEN** submit button is full width indigo-600 with arrow-right icon

#### Scenario: Validation errors
- **WHEN** validation fails
- **THEN** inline error messages appear under each field in red-500 text-sm

### Requirement: Register form
The register page SHALL display a professional registration form.

#### Scenario: Form header
- **WHEN** register form renders
- **THEN** it shows "Create your account" h2 and "Start pre-screening candidates with AI" subtext

#### Scenario: Password strength indicator
- **WHEN** user types password
- **THEN** strength bar shows 1 segment red (weak), 2 amber (medium), 3 green (strong)

#### Scenario: Terms checkbox
- **WHEN** register form renders
- **THEN** checkbox "I agree to the Terms of Service" is displayed

#### Scenario: Create account button
- **WHEN** register form renders
- **THEN** submit button is full width indigo-600
