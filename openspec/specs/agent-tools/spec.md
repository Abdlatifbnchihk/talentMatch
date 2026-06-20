### Requirement: GetCandidateAnalysisTool
The system SHALL provide a `GetCandidateAnalysisTool` implementing `Laravel\Ai\Contracts\Tool`. The tool SHALL accept a `candidate_id` integer parameter and return the full structured analysis for that candidate including candidate name and job offer title. The tool SHALL return an error message string if the candidate is not found or has no analysis.

#### Scenario: Fetch analysis for analyzed candidate
- **WHEN** the AI invokes GetCandidateAnalysisTool with `candidate_id` of a candidate that has been analyzed
- **THEN** the tool returns a JSON object containing `extracted_skills`, `years_experience`, `education_level`, `languages`, `matching_score`, `strengths`, `gaps`, `missing_skills`, `recommendation`, `justification`, `candidate_name`, and `job_offer_title`

#### Scenario: Candidate not found
- **WHEN** the AI invokes GetCandidateAnalysisTool with a `candidate_id` that does not exist
- **THEN** the tool returns an error message string indicating the candidate was not found

#### Scenario: Candidate not yet analyzed
- **WHEN** the AI invokes GetCandidateAnalysisTool with a `candidate_id` of a candidate whose status is `pending`
- **THEN** the tool returns an error message string indicating the candidate has not been analyzed yet

### Requirement: GetJobRequirementsTool
The system SHALL provide a `GetJobRequirementsTool` implementing `Laravel\Ai\Contracts\Tool`. The tool SHALL accept a `job_offer_id` integer parameter and return the job offer's title, description, required_skills, min_experience_years, and status. The tool SHALL return an error message string if the job offer is not found.

#### Scenario: Fetch job requirements
- **WHEN** the AI invokes GetJobRequirementsTool with a valid `job_offer_id`
- **THEN** the tool returns a JSON object containing `title`, `description`, `required_skills`, `min_experience_years`, and `status`

#### Scenario: Job offer not found
- **WHEN** the AI invokes GetJobRequirementsTool with a `job_offer_id` that does not exist
- **THEN** the tool returns an error message string indicating the job offer was not found

### Requirement: CompareCandidatesTool
The system SHALL provide a `CompareCandidatesTool` implementing `Laravel\Ai\Contracts\Tool`. The tool SHALL accept `candidate_id_1` and `candidate_id_2` integer parameters and return a side-by-side comparison object. The tool SHALL return an error message string if either candidate is not found or not analyzed.

#### Scenario: Compare two analyzed candidates
- **WHEN** the AI invokes CompareCandidatesTool with two valid analyzed candidate IDs
- **THEN** the tool returns a JSON object containing `candidate_1` (name, score, recommendation, strengths, gaps, missing_skills), `candidate_2` (same fields), `score_diff` (absolute integer difference), and `better_candidate` (name of the candidate with the higher score)

#### Scenario: One candidate not found
- **WHEN** the AI invokes CompareCandidatesTool with one valid ID and one invalid ID
- **THEN** the tool returns an error message string indicating which candidate was not found

#### Scenario: One candidate not analyzed
- **WHEN** the AI invokes CompareCandidatesTool with a valid ID for a candidate whose status is `pending`
- **THEN** the tool returns an error message string indicating the candidate has not been analyzed yet
