## 1. Layout — app.blade.php

- [x] 1.1 Add Inter font via Google Fonts CDN and Tailwind CSS CDN in head
- [x] 1.2 Build sticky top navbar: briefcase icon + "TalentMatch" logo, center nav links, right avatar dropdown
- [x] 1.3 Build left sidebar (240px, desktop only): logo, nav items with icons (Dashboard, My Offers, Candidates, Settings), active state styling
- [x] 1.4 Add main content offset: ml-0 md:ml-60, padding p-6, max-w-6xl mx-auto
- [x] 1.5 Add flash message banners: success (green) and error (red) with dismiss button
- [x] 1.6 Add footer: "TalentMatch © 2025 · Internal HR Tool"

## 2. Auth — login.blade.php

- [x] 2.1 Build split-screen layout: left indigo-700 panel (hidden mobile) + right white panel
- [x] 2.2 Left panel: white logo, tagline "Smarter hiring, powered by AI", three feature rows with icons
- [x] 2.3 Right panel: "Welcome back 👋" header, email field with envelope icon, password field with lock icon + eye toggle
- [x] 2.4 Add "Remember me" checkbox + "Forgot password?" link, full-width "Sign in" button with arrow icon
- [x] 2.5 Add divider with "or" text and "Don't have an account? Register" link
- [x] 2.6 Add inline validation error display under each field

## 3. Auth — register.blade.php

- [x] 3.1 Build same split-screen layout as login
- [x] 3.2 Right panel: "Create your account" header, name/email/password fields with icons
- [x] 3.3 Add password strength indicator: 1 segment red, 2 amber, 3 green (JS-powered)
- [x] 3.4 Add confirm password field, terms checkbox, "Create account" button, "Already have an account? Sign in" link

## 4. Offers — index.blade.php

- [x] 4.1 Build page header: "My Job Offers" h1 left + "+ Post a new offer" indigo button right
- [x] 4.2 Add filter/search row: status tabs (All/Active/Closed) + search input with magnifier icon
- [x] 4.3 Build LinkedIn-style offer cards: avatar, title, posted by, pills (location, experience), skills pills (first 4 + "+N more"), footer with candidate count + status badge
- [x] 4.4 Add card hover effect: "View candidates →" slides up from bottom
- [x] 4.5 Build empty state: empty briefcase SVG, "No job offers yet" text, "Post your first offer" button
- [x] 4.6 Add client-side search filtering by title (JS)

## 5. Offers — create.blade.php & edit.blade.php

- [x] 5.1 Build two-column layout: form left 65% + live preview right 35% (hidden mobile)
- [x] 5.2 Add breadcrumb, form card with section headings
- [x] 5.3 Section 1 — Job Details: title input, description textarea with character counter, status toggle (edit only)
- [x] 5.4 Section 2 — Skills: tag input (Enter/comma adds pill, X removes), hidden inputs for required_skills[]
- [x] 5.5 Section 2 — Experience: custom stepper (minus/label/plus buttons)
- [x] 5.6 Form footer: Cancel ghost button + Save draft outline button + Publish offer indigo button
- [x] 5.7 Live preview card: mirrors offer card design, updates in real-time via JS input events

## 6. Offers — show.blade.php

- [x] 6.1 Build breadcrumb and offer header card: avatar, title, status badge, "Submit a candidate" button, skills pills, collapsible description
- [x] 6.2 Build stats bar: 4 boxes (Total candidates, Avg score, % Invited, % Rejected)
- [x] 6.3 Build candidate table: header row, data rows with rank, avatar+name, score progress bar, recommendation pill, status dot, action links
- [x] 6.4 Add tab filters (All/Invite ≥70/Hold 40-69/Reject <40) and sort dropdown (By score/By date)
- [x] 6.5 Add skeleton loading state and empty candidates state

## 7. Candidates — create.blade.php

- [x] 7.1 Build centered layout with breadcrumb and offer context card (indigo-50 bg)
- [x] 7.2 Build form card: name input with person icon, email input with envelope icon + hint
- [x] 7.3 Build CV textarea: min-h-64, font-mono, character counter, collapsible tips panel
- [x] 7.4 Build form footer: Cancel button + "✨ Analyze candidate" button + subtext

## 8. Candidates — show.blade.php

- [x] 8.1 Build pending state: loading overlay with spinning circle, progress steps, auto-refresh meta tag
- [x] 8.2 Build analyzed row 1: score card (donut ring SVG, score number, recommendation pill, chat button) + info card (avatar, name, education, experience, languages, skills)
- [x] 8.3 Build analyzed row 2: three-column layout — Strengths (green border/bg), Gaps (amber), Missing skills (red pills)
- [x] 8.4 Build analyzed row 3: Justification card with indigo border and full paragraph

## 9. Chat — show.blade.php (adjustments)

- [x] 9.1 Update sidebar colors to slate-200 borders and white bg
- [x] 9.2 Update message colors to slate-100 borders and white bg

## 10. Verification

- [x] 10.1 Verify layout renders with sidebar, navbar, footer
- [x] 10.2 Verify auth pages show split-screen layout
- [x] 10.3 Verify offers index shows cards with search/filter
- [x] 10.4 Verify offer form shows live preview
- [x] 10.5 Verify candidate detail shows donut ring and three-column analysis
