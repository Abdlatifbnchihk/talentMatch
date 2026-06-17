## Why

TalentMatch needs a job offers management system to allow employers to create, manage, and track job listings. This is the core feature enabling the platform's matching functionality - without job offers, there's nothing to match candidates against.

## What Changes

- Add `JobOffer` model with fields for title, description, required skills, experience requirements, and status
- Create `JobOfferStatus` enum for active/closed states
- Add database migration for `job_offers` table with proper indexes
- Implement `JobOfferController` with full CRUD operations (resource controller)
- Add form request validation for store and update operations
- Create Blade views for listing, creating, editing, and viewing job offers
- Display candidate counts and matching scores on offer views

## Capabilities

### New Capabilities
- `job-offers-crud`: Complete job offers management including model, controller, views, and validation

### Modified Capabilities

_(none - this is a new feature)_

## Impact

- **Models**: New `JobOffer` model with enum cast and user relationship
- **Database**: New `job_offers` table migration with indexes
- **HTTP**: New routes under `/offers` resource endpoint
- **Controllers**: New `JobOfferController` with auth middleware scoping
- **Views**: New Blade views in `resources/views/offers/`
- **Validation**: New `StoreJobOfferRequest` and `UpdateJobOfferRequest` form requests
- **Enums**: New `App\Enums\JobOfferStatus` enum class
