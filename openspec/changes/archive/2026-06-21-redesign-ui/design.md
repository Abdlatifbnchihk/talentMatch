## Context

The TalentMatch application currently uses default Laravel Breeze styling with Tailwind CSS. Views are functional but lack a unified design system. The application is an internal HR tool used by recruiters to evaluate candidates with AI assistance.

Current state:
- 9 Blade view files with inconsistent styling
- No left sidebar navigation
- Basic card layouts without consistent spacing
- Auth views use centered card layout (no branding)

## Goals / Non-Goals

**Goals:**
- Establish a consistent design system across all views
- Create a professional HR SaaS aesthetic (Lever/Greenhouse-inspired)
- Add sidebar navigation for desktop users
- Improve auth views with split-screen branding
- Enhance offer cards with LinkedIn-style design
- Add live preview to offer forms
- Improve candidate detail with donut score ring and three-column analysis

**Non-Goals:**
- No backend changes (controllers, routes, models unchanged)
- No new JavaScript frameworks (vanilla JS only)
- No real-time features beyond existing fetch-based chat
- No responsive redesign for mobile sidebar (hidden on mobile)

## Decisions

1. **Tailwind CSS via CDN** — Include in layout only via `<script src="https://cdn.tailwindcss.com">`. Alternative: compile locally. CDN chosen for simplicity and rapid iteration.

2. **Inter font via Google Fonts** — Single font family for consistency. Alternative: system font stack. Inter chosen for professional appearance.

3. **Left sidebar (240px, desktop only)** — Fixed sidebar with icon+label nav items. Alternative: collapsible sidebar. Fixed chosen for simplicity.

4. **Split-screen auth layout** — Branded left panel (indigo-700) + form right panel. Alternative: centered card. Split-screen chosen for branding impact.

5. **Vanilla JS for interactions** — No Alpine.js or other frameworks. All interactions (tag input, stepper, search, password strength) implemented with plain JS.

6. **Client-side filtering** — Tabs and search filter existing data without API calls. Alternative: server-side filtering. Client-side chosen for instant feedback.

## Risks / Trade-offs

- [CDN dependency for Tailwind] → Acceptable for internal tool; can migrate to compiled later
- [Client-side filtering limited to current page] → Acceptable with 15-item pagination
- [No mobile sidebar] → Acceptable; mobile users use top nav only
- [Large view files] → Acceptable for single-file Blade templates
