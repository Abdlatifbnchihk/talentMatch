## ADDED Requirements

### Requirement: Pending state display
The candidate detail SHALL display a pending state while analysis is in progress.

#### Scenario: Loading overlay
- **WHEN** candidate status is pending
- **THEN** full page overlay shows spinning indigo circle + "AI is analyzing this CV…"

#### Scenario: Progress steps
- **WHEN** candidate status is pending
- **THEN** progress steps show "CV saved ✓" → "Job queued ✓" → "AI analyzing… ⏳" → "Result ready"

#### Scenario: Auto-refresh
- **WHEN** candidate status is pending
- **THEN** page auto-refreshes every 5 seconds

### Requirement: Analyzed state layout
The candidate detail SHALL display analysis results in a structured layout.

#### Scenario: Row 1 layout
- **WHEN** candidate is analyzed
- **THEN** row 1 shows score card (60%) and info card (40%)

#### Scenario: Score card
- **WHEN** score card renders
- **THEN** it shows SVG donut ring (160px), score number center, matching score label, recommendation pill, and chat button

#### Scenario: Info card
- **WHEN** info card renders
- **THEN** it shows avatar, name, education, experience, languages, and extracted skills as pills

### Requirement: Three-column analysis
The candidate detail SHALL display strengths, gaps, and missing skills in three columns.

#### Scenario: Strengths column
- **WHEN** analysis renders
- **THEN** strengths card has green-50 bg, border-l-4 border-green-500, bullet list with checkmark icons

#### Scenario: Gaps column
- **WHEN** analysis renders
- **THEN** gaps card has amber-50 bg, border-l-4 border-amber-500, bullet list with warning icons

#### Scenario: Missing skills column
- **WHEN** analysis renders
- **THEN** missing skills card has red-50 bg, border-l-4 border-red-500, pill tags in red-100/red-700

### Requirement: Justification block
The candidate detail SHALL display the AI justification.

#### Scenario: Justification display
- **WHEN** analysis renders
- **THEN** justification card shows indigo sparkle icon, "AI Justification" heading, and full paragraph with left border-l-4 border-indigo-400
