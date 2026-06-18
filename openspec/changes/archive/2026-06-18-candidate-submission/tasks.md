## 1. Database & Model Setup

- [x] 1.1 Create `CandidateStatus` enum with Pending and Analyzed values
- [x] 1.2 Create migration for `candidates` table with all columns and indexes
- [x] 1.3 Enhance `Candidate` model with enum cast, fillable attributes, and relationships

## 2. Validation

- [x] 2.1 Create `StoreCandidateRequest` form request with validation rules

## 3. Controller & Routes

- [x] 3.1 Create `CandidateController` with create and store methods
- [x] 3.2 Register nested routes under offers in `routes/web.php`

## 4. Views

- [x] 4.1 Create `candidates/create.blade.php` with submission form

## 5. Jobs

- [x] 5.1 Create `AnalyzeCandidateJob` placeholder job

## 6. Polish

- [x] 6.1 Add success flash message after submission
- [x] 6.2 Test full submission flow end-to-end