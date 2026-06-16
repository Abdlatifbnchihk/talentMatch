## ADDED Requirements

### Requirement: Authenticated users are redirected from auth pages
The system SHALL redirect authenticated users away from login and registration pages to prevent unnecessary access.

#### Scenario: Authenticated user tries to access login page
- **WHEN** authenticated user navigates to /login
- **THEN** system redirects user to home page or dashboard

#### Scenario: Authenticated user tries to access registration page
- **WHEN** authenticated user navigates to /register
- **THEN** system redirects user to home page or dashboard

### Requirement: Middleware protects auth routes
The system SHALL use Laravel middleware to check authentication status and redirect accordingly.

#### Scenario: Guest user can access auth pages
- **WHEN** unauthenticated user navigates to /login or /register
- **THEN** system displays the appropriate auth page without redirect

#### Scenario: Middleware is applied to specific routes
- **WHEN** routes are defined in routes/web.php
- **THEN** login and register GET routes have 'guest' middleware applied
