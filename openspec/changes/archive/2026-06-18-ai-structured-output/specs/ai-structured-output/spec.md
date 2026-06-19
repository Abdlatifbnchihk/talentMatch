## ADDED Requirements

### Requirement: AnalysisData DTO
The system SHALL provide an `App\AI\DTOs\AnalysisData` DTO that represents structured AI analysis results.

#### Scenario: DTO properties
- **WHEN** an AnalysisData instance is created
- **THEN** system exposes typed properties: `array $extracted_skills`, `int $years_experience`, `string $education_level`, `array $languages`, `int $matching_score`, `array $strengths`, `array $gaps`, `array $missing_skills`, `string $recommendation`, `string $justification`

#### Scenario: fromArray constructor
- **WHEN** `AnalysisData::fromArray($data)` is called with an associative array
- **THEN** system returns an AnalysisData instance with properties mapped from the array

### Requirement: CandidateAnalysisSchema
The system SHALL provide an `App\AI\Schemas\CandidateAnalysisSchema` that defines the JSON schema for laravel/ai structured output.

#### Scenario: Schema field types
- **WHEN** the schema is used for structured output
- **THEN** system enforces: `extracted_skills` (array of strings), `years_experience` (integer), `education_level` (string), `languages` (array of strings), `matching_score` (integer 0-100), `strengths` (array of strings), `gaps` (array of strings), `missing_skills` (array of strings), `recommendation` (enum: convoquer|attente|rejeter), `justification` (string)

#### Scenario: Recommendation enum constraint
- **WHEN** the schema validates recommendation field
- **THEN** system accepts only "convoquer", "attente", or "rejeter" as valid values

### Requirement: CandidateAnalysisService AI integration
The system SHALL implement `CandidateAnalysisService->analyze()` to call the AI model and return an `AnalysisData` DTO.

#### Scenario: Prompt construction
- **WHEN** analyze() is called with a Candidate
- **THEN** system builds a prompt containing job offer title, required_skills, min_experience_years, description, and candidate cv_text

#### Scenario: AI model call
- **WHEN** the prompt is built
- **THEN** system calls laravel/ai with model `claude-sonnet-4-6` and the CandidateAnalysisSchema for structured output

#### Scenario: Return AnalysisData
- **WHEN** AI returns a valid structured response
- **THEN** system returns an AnalysisData DTO populated with the response data

### Requirement: AnalyzeCandidateJob persistence
The system SHALL update `AnalyzeCandidateJob` to persist AnalysisData results to the Analysis model.

#### Scenario: Job persists AnalysisData
- **WHEN** CandidateAnalysisService returns an AnalysisData DTO
- **THEN** system creates an Analysis record using DTO properties and updates candidate status to `analyzed`

#### Scenario: Job handles null result
- **WHEN** CandidateAnalysisService returns null
- **THEN** system logs error, keeps candidate status as `pending`, and fails the job
