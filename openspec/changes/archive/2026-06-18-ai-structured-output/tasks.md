## 1. Dependencies

- [x] 1.1 Install `laravel/ai` package via composer

## 2. DTO

- [x] 2.1 Create `app/AI/DTOs/AnalysisData.php` with typed properties and `fromArray()` named constructor

## 3. Schema

- [x] 3.1 Create `app/AI/Schemas/CandidateAnalysisSchema.php` defining JSON schema for structured output with all field types and recommendation enum constraint

## 4. Service

- [x] 4.1 Update `app/Services/CandidateAnalysisService.php`: build prompt from job offer + cv_text, call laravel/ai with `claude-sonnet-4-6` and CandidateAnalysisSchema, return AnalysisData DTO
- [x] 4.2 Handle AI failures: log error, return null

## 5. Job Update

- [x] 5.1 Update `app/Jobs/AnalyzeCandidateJob.php`: change `handle()` to accept AnalysisData DTO from service, persist DTO properties to Analysis model, update candidate status to `analyzed`

## 6. Verification

- [x] 6.1 Run Laravel Pint to fix code style
- [x] 6.2 Verify the full flow: service builds prompt → AI returns structured data → DTO created → job persists to database
