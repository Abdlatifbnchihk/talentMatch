## 1. Create Policy

- [x] 1.1 Create `JobOfferPolicy` class in `app/Policies/`
- [x] 1.2 Implement `view`, `update`, and `delete` methods with owner check

## 2. Update Controller

- [x] 2.1 Replace `$this->authorizeOffer()` calls with `$this->authorize()` in `JobOfferController`
- [x] 2.2 Remove the `authorizeOffer()` method from `JobOfferController`

## 3. Test

- [x] 3.1 Test that owners can view, edit, update, and delete their offers
- [x] 3.2 Test that non-owners receive 403 when attempting to access offers they don't own