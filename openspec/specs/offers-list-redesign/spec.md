# Offers List Redesign

## Purpose

LinkedIn-style offer cards with search and filter.

## Requirements

### Requirement: Offers page header
The offers index SHALL display a header with title and create button.

#### Scenario: Header layout
- **WHEN** offers index renders
- **THEN** header shows "My Job Offers" h1 on left and "+ Post a new offer" indigo button on right

### Requirement: Offer search and filter
The offers index SHALL provide search and filter controls.

#### Scenario: Status tabs
- **WHEN** offers index renders
- **THEN** tabs show "All", "Active", "Closed" with indigo underline on active

#### Scenario: Search input
- **WHEN** offers index renders
- **THEN** search input with magnifier icon filters cards by title client-side

### Requirement: Offer cards
The offers index SHALL display offers as LinkedIn-style cards.

#### Scenario: Card layout
- **WHEN** offer card renders
- **THEN** it shows avatar circle, job title, posted by, pills row, skills row, divider, footer row

#### Scenario: Skills display
- **WHEN** offer has more than 4 skills
- **THEN** first 4 skills show as indigo pills and "+N more" slate pill appears

#### Scenario: Status badge
- **WHEN** offer card renders
- **THEN** footer shows candidate count left and status badge right (green "Active" or slate "Closed")

#### Scenario: Card hover
- **WHEN** user hovers over offer card
- **THEN** "View candidates →" indigo text button slides up from bottom

### Requirement: Empty state
The offers index SHALL display an empty state when no offers exist.

#### Scenario: No offers
- **WHEN** user has no offers
- **THEN** centered empty briefcase SVG, "No job offers yet" text, and "Post your first offer" indigo button appear
