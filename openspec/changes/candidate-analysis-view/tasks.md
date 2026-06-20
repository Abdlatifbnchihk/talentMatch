## 1. Controller Update

- [x] 1.1 Update `CandidateController@show`: load candidate with `latestAnalysis` and `jobOffer`, handle pending status with meta refresh view, pass analysis to analyzed view

## 2. View Rebuild

- [x] 2.1 Create pending analysis view with "Analysis in progress…" message and `<meta http-equiv="refresh" content="5">`
- [x] 2.2 Build header section: candidate name, job offer title, submitted date
- [x] 2.3 Build score widget: large badge with matching_score/100, color coding (green ≥70, amber 40–69, red <40)
- [x] 2.4 Build recommendation pill using Recommendation enum `badgeColor()` and `label()`
- [x] 2.5 Build three-column grid: Strengths (checkmark icon), Gaps (warning icon), Missing skills (pill tags)
- [x] 2.6 Build justification block: full paragraph
- [x] 2.7 Build sidebar: years_experience, education_level, extracted_skills (pills), languages
- [x] 2.8 Build CTA button: "Open chat assistant" → /candidates/{candidate}/chat

## 3. Verification

- [x] 3.1 Run Laravel Pint to fix code style
- [x] 3.2 Verify pending state auto-refreshes and analyzed state shows full layout
