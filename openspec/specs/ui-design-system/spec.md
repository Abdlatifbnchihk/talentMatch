# UI Design System

## Purpose

Consistent design tokens and styling across all TalentMatch views.

## Requirements

### Requirement: Global design tokens
The system SHALL apply consistent design tokens across all views.

#### Scenario: Font family
- **WHEN** any page renders
- **THEN** Inter font is loaded from Google Fonts CDN and applied to body

#### Scenario: Primary color
- **WHEN** interactive elements render
- **THEN** primary color is indigo-600 (#4F46E5)

#### Scenario: Background color
- **WHEN** page body renders
- **THEN** background is slate-50 (#F8FAFC)

#### Scenario: Card styling
- **WHEN** card components render
- **THEN** they have white bg, 1px border-slate-200, shadow-sm, rounded-xl

#### Scenario: Text colors
- **WHEN** text renders
- **THEN** headings use slate-800, body uses slate-600, muted uses slate-400

#### Scenario: Border radius
- **WHEN** components render
- **THEN** cards use rounded-xl, inputs use rounded-lg, pills use rounded-full

#### Scenario: Transitions
- **WHEN** interactive elements render
- **THEN** they have transition-all duration-200

### Requirement: Tailwind CSS via CDN
The system SHALL load Tailwind CSS via CDN in the layout.

#### Scenario: CDN script tag
- **WHEN** layout renders
- **THEN** Tailwind CSS CDN script is included in head
