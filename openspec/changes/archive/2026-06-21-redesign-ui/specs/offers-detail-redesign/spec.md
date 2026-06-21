## ADDED Requirements

### Requirement: Offer detail header
The offer detail SHALL display a header card with offer info.

#### Scenario: Header layout
- **WHEN** offer detail renders
- **THEN** header shows avatar, title, status badge, and "Submit a candidate" button

#### Scenario: Skills row
- **WHEN** offer detail renders
- **THEN** all skills are shown as indigo pills

#### Scenario: Description collapsible
- **WHEN** description exceeds 3 lines
- **THEN** "Read more / Show less" toggle appears

### Requirement: Stats bar
The offer detail SHALL display a stats bar with four metrics.

#### Scenario: Stats layout
- **WHEN** offer detail renders
- **THEN** four stat boxes show: Total candidates, Avg score, % Invited, % Rejected

#### Scenario: Stat values
- **WHEN** stats render
- **THEN** each box shows large number in font-bold slate-800 and label in text-xs slate-400

### Requirement: Candidate table
The offer detail SHALL display a sortable, filterable candidate table.

#### Scenario: Table header
- **WHEN** candidate table renders
- **THEN** header shows: #, Candidate, Score, Recommendation, Status, Actions

#### Scenario: Score column
- **WHEN** candidate row renders
- **THEN** score shows as progress bar (100px) with color coding (green ≥70, amber 40-69, red <40)

#### Scenario: Status column
- **WHEN** candidate row renders
- **THEN** status shows green dot "Analyzed" or amber spinning dot "Pending"

#### Scenario: Tab filters
- **WHEN** candidate table renders
- **THEN** tabs show "All", "Invite ≥70", "Hold 40-69", "Reject <40"

#### Scenario: Sort dropdown
- **WHEN** candidate table renders
- **THEN** sort dropdown offers "By score" and "By date" options

### Requirement: Empty candidates state
The offer detail SHALL display an empty state when no candidates exist.

#### Scenario: No candidates
- **WHEN** offer has no candidates
- **THEN** "No candidates yet — be the first to submit a CV" centered message appears
