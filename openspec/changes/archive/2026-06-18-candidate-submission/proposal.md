## Why

TalentMatch needs a way for candidates to submit their CVs for job offers. This is the entry point for the matching system - without candidate submissions, there's nothing to analyze or match against job requirements.

## What Changes

- Enhance `Candidate` model with proper fields, enum cast, and relationships
- Create `CandidateStatus` enum for pending/analyzed states
- Add database migration for `candidates` table with proper indexes
- Implement `CandidateController` with create and store actions
- Add form request validation for candidate submission
- Create Blade view for candidate submission form
- Dispatch `AnalyzeCandidateJob` after submission (placeholder)

## Capabilities

### New Capabilities
- `candidate-submission`: Candidate CV submission flow including model, controller, views, and job dispatch

### Modified Capabilities

_(none - this is a new feature)_

## Impact

- **Models**: Enhanced `Candidate` model with enum cast, fillable attributes, and relationships
- **Database**: New `candidates` table migration with indexes on job_offer_id and status
- **HTTP**: New routes under `/offers/{offer}/candidates` for create and store
- **Controllers**: New `CandidateController` with scoped actions
- **Views**: New Blade view in `resources/views/candidates/`
- **Validation**: New `StoreCandidateRequest` form request
- **Enums**: New `App\Enums\CandidateStatus` enum class
- **Jobs**: New `AnalyzeCandidateJob` placeholder job
