## Context

TalentMatch is a Laravel 11 application with a JobOfferController that currently uses a custom `authorizeOffer` method for access control. This method checks if `$offer->user_id !== auth()->id()` and aborts with 403. The application follows standard Laravel conventions with Blade views, Eloquent models, and resource controllers.

## Goals / Non-Goals

**Goals:**
- Replace custom authorization with Laravel Policy
- Follow framework conventions for authorization
- Improve testability of authorization logic
- Maintain same security behavior (403 for unauthorized access)

**Non-Goals:**
- Changing authorization rules (still owner-only access)
- Adding role-based access control
- Modifying view or model layers
- Changing HTTP response codes for unauthorized access

## Decisions

**1. Policy Implementation: Simple owner check**
- Create `JobOfferPolicy` with `view`, `update`, and `delete` methods
- Each method returns `true` if `$offer->user_id === $user->id`
- Rationale: Simple, follows Laravel convention, matches existing behavior
- Alternative considered: Gate-based authorization - rejected for cleaner separation

**2. Controller Integration: Use $this->authorize()**
- Replace `$this->authorizeOffer($offer)` with `$this->authorize('view', $offer)`
- Keep same methods: show, edit, update, destroy
- Rationale: Standard Laravel pattern, automatic 403 response
- Alternative considered: Manual Gate::authorize() - rejected for consistency

**3. Registration: Auto-discovery**
- Laravel 11 auto-discovers policies in `app/Policies/` directory
- No manual registration needed in AuthServiceProvider
- Rationale: Simplifies setup, follows Laravel 11 conventions

**4. Error Handling: Consistent 403 responses**
- Policy methods return boolean, Laravel handles 403 automatically
- No custom exception handling needed
- Rationale: Standard behavior, consistent with other authorization checks

## Risks / Trade-offs

**[Risk]** Auto-discovery may not work in some configurations
→ **Mitigation**: Can manually register in AuthServiceProvider if needed

**[Risk]** Policy methods may be called in different contexts (guest users)
→ **Mitigation**: Laravel handles guest users automatically (returns false)

**[Trade-off]** Simplicity over flexibility - single policy for all operations
→ **Acceptable**: Current requirements only need owner-based authorization

**[Trade-off]** No custom 404 response for non-owners
→ **Acceptable**: 403 is appropriate for authorization failures, not 404
