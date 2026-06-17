## 1. Database & Model Setup

- [x] 1.1 Create `JobOfferStatus` enum with Active and Closed values
- [x] 1.2 Create migration for `job_offers` table with all columns and indexes
- [x] 1.3 Create `JobOffer` model with enum cast, array cast for skills, and user relationship

## 2. Validation

- [x] 2.1 Create `StoreJobOfferRequest` form request with validation rules
- [x] 2.2 Create `UpdateJobOfferRequest` extending Store with optional status field

## 3. Controller & Routes

- [x] 3.1 Create `JobOfferController` with resource methods scoped to auth user
- [x] 3.2 Register resource route in `routes/web.php` with auth middleware

## 4. Views

- [x] 4.1 Create `offers/index.blade.php` with table listing offers
- [x] 4.2 Create `offers/create.blade.php` with offer form
- [x] 4.3 Create `offers/edit.blade.php` with pre-filled offer form
- [x] 4.4 Create `offers/show.blade.php` with offer details and candidates table

## 5. Polish

- [x] 5.1 Add navigation links to the offers section
- [x] 5.2 Test full CRUD flow end-to-end
