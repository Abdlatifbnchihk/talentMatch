## Context

TalentMatch is a Laravel 11 application for matching job candidates with employers. The platform currently has a Candidate model that stores CV submissions. The next step is to store structured AI analysis results for each candidate, which will power the candidate detail view and the conversational assistant.

The application follows standard Laravel conventions with Blade views, Eloquent models, and resource controllers. The existing `CandidateAnalysis` model exists but has no migration and uses a default table name (`candidate_analyses`) instead of the intended `analyses` table.

## Goals / Non-Goals

**Goals:**
- Create an `Analysis` model to store structured AI output for candidates
- Establish a one-to-many relationship between Candidate and Analysis
- Provide typed enums for recommendation with helper methods (label, badge color)
- Ensure proper database indexes for performance on common queries

**Non-Goals:**
- AI analysis implementation (just the data structure)
- Real-time analysis status updates
- Analysis comparison UI (future feature)
- Analysis history or versioning

## Decisions

**1. Table naming: `analyses` instead of `candidate_analyses`**
- Use `analyses` as the table name for simplicity and clarity
- Add `protected $table = 'analyses';` to the CandidateAnalysis model
- Rationale: The config.yml specifies `analyses` as the table name; shorter name is cleaner
- Alternative considered: Use Laravel's default pluralization (`candidate_analyses`) - rejected for inconsistency with config

**2. One-to-many relationship instead of one-to-one**
- Candidate hasMany Analysis (not hasOne)
- Rationale: A candidate may be analyzed multiple times (e.g., re-analysis after CV update, different analysis versions)
- Alternative considered: One-to-one for simplicity - rejected for flexibility

**3. Enum for recommendation with helper methods**
- Create `App\Enums\Recommendation` backed string enum
- Add `label()` method returning human-readable labels
- Add `badgeColor()` method returning Tailwind color classes
- Rationale: Centralizes presentation logic in the enum, keeps views clean

**4. JSON columns for array data**
- Use `json` column type for extracted_skills, languages, strengths, gaps, missing_skills
- Cast to `array` in the model
- Rationale: Native MySQL JSON support, automatic encoding/decoding via Eloquent

**5. Unique constraint on candidate_id**
- Add unique index on `candidate_id` to enforce one analysis per candidate per version
- Rationale: Prevents duplicate analyses while allowing re-analysis by deleting old record first

## Risks / Trade-offs

**[Risk]** One-to-many may complicate queries for "latest analysis"
→ **Mitigation**: Add `latestOfMany()` relationship for convenience, or query with `orderBy('created_at', 'desc')->first()`

**[Risk]** JSON columns may be harder to query than normalized tables
→ **Mitigation**: Acceptable for read-heavy use case; queries filter on scalar fields (matching_score, recommendation)

**[Trade-off]** Enum label/badge methods in backend vs frontend
→ **Acceptable**: Keeps presentation logic centralized; Blade views stay clean