## Why

The current candidate analysis view is a basic two-column layout that doesn't clearly present analysis results. Users need a richer, more organized view that highlights the matching score, recommendation, strengths/gaps, and sidebar details at a glance. The pending state also needs a auto-refresh mechanism so users see results once analysis completes.

## What Changes

- Redesigned `CandidateController@show` to handle pending vs analyzed states with auto-refresh
- Complete rebuild of `candidates/show.blade.php` with new layout: header, score widget, recommendation pill, three-column grid, justification block, sidebar, and CTA button
- Uses existing `Recommendation` enum `badgeColor()` and `label()` helpers

## Capabilities

### New Capabilities

(none)

### Modified Capabilities

- `candidate-analysis`: Adding analysis detail view with pending auto-refresh and redesigned layout

## Impact

- Modified: `app/Http/Controllers/CandidateController.php` (show method)
- Modified: `resources/views/candidates/show.blade.php` (complete rebuild)
