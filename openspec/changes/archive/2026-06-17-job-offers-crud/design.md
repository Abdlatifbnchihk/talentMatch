## Context

TalentMatch is a Laravel 11 application for matching job candidates with employers. The platform currently has a User model but lacks job offer management. This change introduces the core job offers CRUD functionality, which is foundational for the matching system.

The application follows standard Laravel conventions with Blade views, Eloquent models, and resource controllers. Authentication is already implemented via Laravel's built-in auth system.

## Goals / Non-Goals

**Goals:**
- Provide employers with a complete job offers management interface
- Enable listing, creating, editing, viewing, and closing job offers
- Display candidate counts and matching scores per offer
- Ensure all queries are scoped to the authenticated user's offers
- Follow Laravel 11 conventions and existing code patterns

**Non-Goals:**
- Candidate application workflow (separate feature)
- Advanced search/filtering for offers (future enhancement)
- API endpoints (web-only for now)
- Bulk operations on offers
- Soft deletes for offers

## Decisions

**1. Model Design: Single `JobOffer` model with enum status**
- Use a single model with `status` field rather than separate tables for active/closed
- Rationale: Simpler queries, easier transitions between states, standard pattern for status-based entities
- Alternative considered: Separate `active_offers` and `closed_offers` tables - rejected due to complexity

**2. Skills Storage: JSON column with array cast**
- Store `required_skills` as JSON column with `array` cast on the model
- Rationale: Native MySQL/PostgreSQL JSON support, easy querying, Laravel's cast system handles serialization
- Alternative considered: Separate `job_offer_skills` pivot table - rejected for simplicity since skills are display-only

**3. Controller Pattern: Resource controller with auth scoping**
- Use `Route::resource()` with a single `JobOfferController`
- Scope all queries to `auth()->user()->offers` for data isolation
- Rationale: Standard Laravel pattern, clean URL structure, automatic middleware

**4. Validation: Separate FormRequest classes**
- Create `StoreJobOfferRequest` and `UpdateJobOfferRequest` for validation
- `UpdateJobOfferRequest` extends `StoreJobOfferRequest` and adds optional `status` field
- Rationale: Clean separation, reusable validation logic, follows Laravel best practices

**5. Views: Blade components extending main layout**
- Use `resources/views/offers/` directory with index, create, edit, show views
- Extend `layouts/app.blade.php` for consistent styling
- Rationale: Standard Laravel Blade structure, reusable layout

## Risks / Trade-offs

**[Risk]** JSON skills column may limit querying capabilities
→ **Mitigation**: Acceptable for current use case; can migrate to pivot table later if complex filtering needed

**[Risk]** No soft deletes means accidental deletion is permanent
→ **Mitigation**: Confirm deletion with user; add soft deletes in future if needed

**[Trade-off]** Simplicity over flexibility - using enum for status rather than configurable states
→ **Acceptable**: Status options are well-defined (active/closed) and unlikely to change frequently

**[Trade-off]** Web-only interface without API
→ **Acceptable**: Matches current requirements; API can be added later following same controller logic
