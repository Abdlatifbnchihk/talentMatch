# Layout Navigation

## Purpose

Global layout with navbar, sidebar, flash messages, and footer.

## Requirements

### Requirement: Sticky top navbar
The layout SHALL display a sticky top navbar.

#### Scenario: Navbar content
- **WHEN** navbar renders
- **THEN** it shows briefcase SVG icon + "TalentMatch" text on left, nav links in center, avatar dropdown on right

#### Scenario: Navbar styling
- **WHEN** navbar renders
- **THEN** it has white bg, border-b border-slate-200, shadow-sm, sticky top

#### Scenario: Active nav link
- **WHEN** a nav link is active
- **THEN** it has indigo-600 color and border-b-2 border-indigo-600

#### Scenario: Avatar dropdown
- **WHEN** user clicks avatar
- **THEN** dropdown shows Profile and Logout options

### Requirement: Left sidebar navigation
The layout SHALL display a left sidebar on desktop.

#### Scenario: Sidebar visibility
- **WHEN** layout renders on desktop (≥ 768px)
- **THEN** left sidebar is visible at 240px width

#### Scenario: Sidebar visibility on mobile
- **WHEN** layout renders on mobile (< 768px)
- **THEN** left sidebar is hidden

#### Scenario: Sidebar nav items
- **WHEN** sidebar renders
- **THEN** it shows nav items with icon + label: Dashboard, My Offers, Candidates, Settings

#### Scenario: Active sidebar item
- **WHEN** a sidebar item is active
- **THEN** it has indigo-50 bg, indigo-600 text and icon, left border-l-4 border-indigo-600

#### Scenario: Main content offset
- **WHEN** sidebar renders
- **THEN** main content has ml-0 md:ml-60

### Requirement: Flash message banners
The layout SHALL display styled flash message banners.

#### Scenario: Success banner
- **WHEN** success flash message exists
- **THEN** banner shows green-50 bg, green-700 text, green checkmark icon, dismiss X button

#### Scenario: Error banner
- **WHEN** error flash message exists
- **THEN** banner shows red-50 bg, red-700 text, red alert icon, dismiss X button

### Requirement: Footer
The layout SHALL display a footer.

#### Scenario: Footer content
- **WHEN** footer renders
- **THEN** it shows "TalentMatch © 2025 · Internal HR Tool" in slate-400 text-sm text-center py-6
