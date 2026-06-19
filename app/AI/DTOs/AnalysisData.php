<?php

namespace App\AI\DTOs;

readonly class AnalysisData
{
    /**
     * Create a new AnalysisData instance from an array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            extracted_skills: $data['extracted_skills'] ?? [],
            years_experience: $data['years_experience'] ?? 0,
            education_level: $data['education_level'] ?? '',
            languages: $data['languages'] ?? [],
            matching_score: $data['matching_score'] ?? 0,
            strengths: $data['strengths'] ?? [],
            gaps: $data['gaps'] ?? [],
            missing_skills: $data['missing_skills'] ?? [],
            recommendation: $data['recommendation'] ?? '',
            justification: $data['justification'] ?? '',
        );
    }

    public function __construct(
        public array $extracted_skills,
        public int $years_experience,
        public string $education_level,
        public array $languages,
        public int $matching_score,
        public array $strengths,
        public array $gaps,
        public array $missing_skills,
        public string $recommendation,
        public string $justification,
    ) {}
}
