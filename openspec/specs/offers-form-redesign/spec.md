# Offers Form Redesign

## Purpose

Two-column form with live preview for creating and editing offers.

## Requirements

### Requirement: Two-column form layout
Offer forms SHALL display a two-column layout with form left and live preview right.

#### Scenario: Form layout
- **WHEN** offer form renders
- **THEN** form takes 65% width on left and live preview takes 35% on right (hidden on mobile)

#### Scenario: Breadcrumb
- **WHEN** offer form renders
- **THEN** breadcrumb shows "Offers / Create new offer" or "Offers / Edit offer" in slate-400

### Requirement: Job details section
The form SHALL include a job details section.

#### Scenario: Title input
- **WHEN** form renders
- **THEN** title input has placeholder "e.g. Senior Laravel Developer"

#### Scenario: Description textarea
- **WHEN** form renders
- **THEN** description textarea has min-h-40 and character counter "0 / 2000"

#### Scenario: Status toggle
- **WHEN** edit form renders
- **THEN** toggle switch shows "Active / Closed" with indigo when active

### Requirement: Skills tag input
The form SHALL include a tag input for skills.

#### Scenario: Add skill
- **WHEN** user types a skill and presses Enter or comma
- **THEN** skill appears as indigo pill tag with X remove button

#### Scenario: Remove skill
- **WHEN** user clicks X on a skill tag
- **THEN** tag is removed and hidden input is updated

#### Scenario: Hidden inputs
- **WHEN** form renders
- **THEN** hidden inputs are generated for each skill as required_skills[]

### Requirement: Experience stepper
The form SHALL include a custom experience stepper.

#### Scenario: Stepper layout
- **WHEN** form renders
- **THEN** stepper shows minus button, "3 years" label, plus button in a row

#### Scenario: Increment
- **WHEN** user clicks plus button
- **THEN** experience value increases by 1

#### Scenario: Decrement
- **WHEN** user clicks minus button
- **THEN** experience value decreases by 1 (min 0)

### Requirement: Live preview
The form SHALL display a live preview that updates as user types.

#### Scenario: Preview updates
- **WHEN** user types in form fields
- **THEN** preview card updates in real-time showing the offer card design

#### Scenario: Preview placeholder
- **WHEN** form fields are empty
- **THEN** preview shows placeholder text in slate-300
