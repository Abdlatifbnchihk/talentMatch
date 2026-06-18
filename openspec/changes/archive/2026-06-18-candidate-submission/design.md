## Context

TalentMatch is a Laravel 11 application for matching job candidates with employers. The platform currently has a minimal Candidate model but lacks the submission flow. This change introduces the candidate CV submission feature, which is the entry point for the matching system.

The application follows standard Laravel conventions with Blade views, Eloquent models, and resource controllers. Authentication is already implemented via Laravel's built-in auth system.

## Goals / Non-Goals

**Goals:**
- Allow candidates to submit their CVs for specific job offers
- Validate and store candidate submissions with proper status tracking
- Dispatch background job for CV analysis after submission
- Provide clear feedback on submission success

**Non-Goals:**
- CV analysis implementation (placeholder job only)
- Candidate authentication (public submission)
- Multiple CV versions per candidate
- CV file upload (text-only for now)
- Real-time analysis status updates

## Decisions

**1. Model Design: Enhance existing Candidate model**
- Add proper fields: name, cv_text, status with enum cast
- Use existing relationships (belongsTo JobOffer, hasOne Analysis)
- Rationale: Model already exists, just needs proper attributes
- Alternative considered: Create new model - rejected for unnecessary complexity

**2. Status Enum: Simple pending/analyzed states**
- Use `CandidateStatus` enum with Pending and Analyzed values
- Default status is Pending on submission
- Rationale: Simple state machine for initial implementation
- Alternative considered: More states (processing, failed) - rejected for simplicity

**3. Controller Pattern: Nested resource under JobOffer**
- Use nested routes: `/offers/{offer}/candidates/create` and `/offers/{offer}/candidates`
- Scope all queries to specific job offer
- Rationale: Candidates are always submitted for a specific offer
- Alternative considered: Standalone candidate routes - rejected for better UX

**4. Validation: FormRequest with text-based CV**
- Create `StoreCandidateRequest` for validation
- CV stored as text (longtext) not file upload
- Rationale: Simpler implementation, matches requirements
- Alternative considered: File upload - rejected for complexity

**5. Job Dispatch: Placeholder for future implementation**
- Dispatch `AnalyzeCandidateJob` after submission
- Job does nothing for now, just logs
- Rationale: Sets up architecture for future analysis
- Alternative considered: Synchronous analysis - rejected for async requirement

## Risks / Trade-offs

**[Risk]** Text-only CV may limit analysis capabilities
→ **Mitigation**: Acceptable for initial implementation; file upload can be added later

**[Risk]** No real-time feedback on analysis status
→ **Mitigation**: Acceptable for MVP; can add polling/websockets later

**[Trade-off]** Simplicity over flexibility - single submission per candidate
→ **Acceptable**: Matches current requirements; can add versioning later

**[Trade-off]** Public submission without authentication
→ **Acceptable**: Candidate submissions should be open; employer auth is separate
