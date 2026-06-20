## ADDED Requirements

### Requirement: Analysis detail view
The system SHALL display a detailed analysis view for a candidate at GET /offers/{offer}/candidates/{candidate}.

#### Scenario: Pending analysis view
- **WHEN** candidate status is `pending`
- **THEN** system displays "Analysis in progress…" message with meta refresh every 5 seconds

#### Scenario: Analyzed candidate view
- **WHEN** candidate status is `analyzed`
- **THEN** system displays full analysis with score widget, recommendation, strengths, gaps, missing skills, justification, and sidebar details

### Requirement: Score widget
The system SHALL display a large badge showing matching_score out of 100 with color coding.

#### Scenario: High score
- **WHEN** matching_score is ≥ 70
- **THEN** system displays score badge in green

#### Scenario: Medium score
- **WHEN** matching_score is between 40 and 69
- **THEN** system displays score badge in amber

#### Scenario: Low score
- **WHEN** matching_score is < 40
- **THEN** system displays score badge in red

### Requirement: Recommendation pill
The system SHALL display a recommendation pill using the Recommendation enum helpers.

#### Scenario: Display recommendation
- **WHEN** analysis has a recommendation
- **THEN** system displays pill with `badgeColor()` class and `label()` text

### Requirement: Three-column analysis layout
The system SHALL display strengths, gaps, and missing skills in a three-column grid.

#### Scenario: Strengths column
- **WHEN** analysis has strengths
- **THEN** system displays strengths list with checkmark icon

#### Scenario: Gaps column
- **WHEN** analysis has gaps
- **THEN** system displays gaps list with warning icon

#### Scenario: Missing skills column
- **WHEN** analysis has missing_skills
- **THEN** system displays missing skills as pill tags

### Requirement: Justification block
The system SHALL display the full justification text.

#### Scenario: Show justification
- **WHEN** analysis has justification
- **THEN** system displays full paragraph text

### Requirement: Sidebar details
The system SHALL display analysis metadata in a sidebar.

#### Scenario: Sidebar content
- **WHEN** analysis is displayed
- **THEN** system shows years_experience, education_level, extracted_skills (pills), and languages

### Requirement: Chat CTA button
The system SHALL display a call-to-action button for chat assistant.

#### Scenario: CTA link
- **WHEN** analysis view is rendered
- **THEN** system displays "Open chat assistant" button linking to /candidates/{candidate}/chat
