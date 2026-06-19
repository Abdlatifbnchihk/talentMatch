## Why

The `CandidateAnalysisService` currently returns null (stub). To enable real AI-powered candidate analysis, we need a structured output layer using the `laravel/ai` SDK with a typed DTO, JSON schema enforcement, and a proper prompt template. This connects the existing job pipeline to an actual AI model.

## What Changes

- New `App\AI\DTOs\AnalysisData` DTO with typed properties and `fromArray()` constructor
- New `App\AI\Schemas\CandidateAnalysisSchema` for laravel/ai structured output
- Updated `App\Services\CandidateAnalysisService` to call AI with prompt and return `AnalysisData`
- Updated `AnalyzeCandidateJob` to persist `AnalysisData` DTO to `Analysis` model
- `laravel/ai` package added to composer dependencies

## Capabilities

### New Capabilities

- `ai-structured-output`: AI analysis layer with DTO, schema, and service integration

### Modified Capabilities

- `candidate-analysis`: Service stub replaced with real AI integration returning AnalysisData DTO

## Impact

- New files: `app/AI/DTOs/AnalysisData.php`, `app/AI/Schemas/CandidateAnalysisSchema.php`
- Modified: `app/Services/CandidateAnalysisService.php`, `app/Jobs/AnalyzeCandidateJob.php`
- Modified: `composer.json` (add `laravel/ai` dependency)
