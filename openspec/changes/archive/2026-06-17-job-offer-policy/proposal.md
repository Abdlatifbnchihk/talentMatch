## Why

The JobOfferController currently uses a custom `authorizeOffer` method for access control. This should be replaced with a proper Laravel Policy to follow framework conventions, improve testability, and enable policy-based authorization throughout the application.

## What Changes

- Add `JobOfferPolicy` with view, update, and delete methods checking `offer.user_id === Auth::id()`
- Register policy in `AuthServiceProvider`
- Replace `$this->authorizeOffer()` calls with `$this->authorize()` in `JobOfferController`
- Return 403 for unauthorized access without leaking resource existence

## Capabilities

### New Capabilities
- `job-offer-policy`: Laravel Policy for Job Offer authorization

### Modified Capabilities
- `job-offers-crud`: Update controller to use Policy instead of custom authorization method

## Impact

- **Models**: No changes to JobOffer model
- **Auth**: New `JobOfferPolicy` class in `app/Policies/`
- **Providers**: Register policy in `AuthServiceProvider`
- **Controllers**: Update `JobOfferController` to use `$this->authorize()` calls
- **Views**: No changes required
