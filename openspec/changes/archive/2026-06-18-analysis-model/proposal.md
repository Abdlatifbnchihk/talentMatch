## Why

TalentMatch needs structured AI analysis output for candidates. After a candidate submits their CV, the system analyzes it and stores the results (skills, experience, score, recommendation) for later retrieval and comparison. This data powers the candidate detail view and the conversational assistant.

## What Changes

- Create `Analysis` model with structured fields for AI output
- Create `Recommendation` enum with label and badge color helpers
- Add migration for `analyses` table with proper indexes
- Update `Candidate` model to establish one-to-many relationship with Analysis

## Capabilities

### New Capabilities
- `candidate-analysis`: Structured AI analysis storage for candidates, including extracted skills, experience, education, languages, matching score, strengths, gaps, missing skills, recommendation, and justification

### Modified Capabilities

_(none - this is a new feature)_

## Impact

- **Models**: New `Analysis` model with JSON array casts and enum cast for recommendation
- **Enums**: New `App\Enums\Recommendation` enum class with helper methods
- **Database**: New `analyses` table migration with indexes on matching_score and recommendation
- **Relationships**: Updated `Candidate` model to add `hasOne` relationship to Analysis
- **Views**: Analysis data will be displayed in candidate detail view (future task)