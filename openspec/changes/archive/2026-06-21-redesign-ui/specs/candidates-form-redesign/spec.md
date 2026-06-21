## ADDED Requirements

### Requirement: Candidate form layout
The candidate form SHALL display a centered layout with offer context.

#### Scenario: Breadcrumb
- **WHEN** candidate form renders
- **THEN** breadcrumb shows "Offers / {offer title} / Submit candidate"

#### Scenario: Offer context card
- **WHEN** candidate form renders
- **THEN** indigo-50 card shows offer title, first 4 skills, and min experience

### Requirement: Candidate info section
The form SHALL include candidate info inputs.

#### Scenario: Name input
- **WHEN** form renders
- **THEN** name input has person icon left

#### Scenario: Email input
- **WHEN** form renders
- **THEN** email input has envelope icon left and "(for your records only)" hint

### Requirement: CV content section
The form SHALL include a CV paste area.

#### Scenario: Textarea
- **WHEN** form renders
- **THEN** CV textarea has min-h-64, font-mono, and character counter

#### Scenario: Tips panel
- **WHEN** form renders
- **THEN** collapsible tips panel shows "For best results include:" with bullet list

### Requirement: Form footer
The form SHALL include action buttons.

#### Scenario: Buttons
- **WHEN** form renders
- **THEN** "Cancel" ghost button is on left and "✨ Analyze candidate" indigo button is on right

#### Scenario: Subtext
- **WHEN** form renders
- **THEN** "Analysis usually completes in 5–10 seconds" text appears below button
