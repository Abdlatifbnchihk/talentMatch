## Context

The existing `CandidateController@show` loads `analyses` (plural) and renders a basic two-column Blade view. The candidate may be in `pending` or `analyzed` status. The `Analysis` model has all fields needed (matching_score, recommendation, strengths, gaps, missing_skills, justification, etc.). The `Recommendation` enum provides `label()` and `badgeColor()` helpers.

## Goals / Non-Goals

**Goals:**
- Show "Analysis in progress…" with meta refresh when status is pending
- Redesign the view with header, score widget, recommendation pill, three-column grid, justification, sidebar, and CTA
- Use existing Blade component patterns (`x-app-layout`, Tailwind classes)

**Non-Goals:**
- Chat assistant implementation (CTA is a placeholder link)
- Real-time websockets for analysis status (meta refresh is sufficient)
- Mobile-specific layout (responsive Tailwind handles it)

## Decisions

- **Meta refresh for pending state**: Simple, no JS dependency, auto-polls every 5 seconds. Alternative: JavaScript polling (rejected — more complexity, not needed for this use case).
- **Score widget thresholds**: green ≥70, amber 40–69, red <40 (per user spec). Different from existing 80/50 thresholds in index view.
- **Three-column grid**: Strengths, Gaps, Missing skills side by side on desktop, stacked on mobile.
- **Sidebar**: Right column on desktop with experience, education, extracted skills, languages.
- **Uses `latestAnalysis()` relationship**: Single analysis per candidate via HasOne.

## Risks / Trade-offs

- [Meta refresh every 5s] → May cause flicker; acceptable for short analysis duration
- [No real-time] → User must wait for page refresh; acceptable given 90s job timeout
