<?php

namespace App\Services;

use App\AI\DTOs\AnalysisData;
use App\AI\Schemas\CandidateAnalysisSchema;
use App\Models\Candidate;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Ai;

class CandidateAnalysisService
{
    /**
     * Analyze a candidate's CV against their job offer using AI.
     */
    public function analyze(Candidate $candidate): ?AnalysisData
    {
        $candidate->load('jobOffer');

        $jobOffer = $candidate->jobOffer;

        $prompt = <<<'PROMPT'
You are an expert HR analyst. Analyze the CV against this job offer.

JOB OFFER: {title}
REQUIRED SKILLS: {required_skills}
MINIMUM EXPERIENCE: {min_experience_years} years
DESCRIPTION: {description}

CANDIDATE CV:
{cv_text}

Return only the JSON analysis. Be objective and base all judgments on the CV content only.
PROMPT;

        $prompt = str_replace(
            ['{title}', '{required_skills}', '{min_experience_years}', '{description}', '{cv_text}'],
            [
                $jobOffer->title,
                implode(', ', $jobOffer->required_skills ?? []),
                $jobOffer->min_experience_years,
                $jobOffer->description,
                $candidate->cv_text,
            ],
            $prompt
        );

        $schema = new CandidateAnalysisSchema;

        $response = Ai::text()->prompt($prompt, schema: $schema);

        $data = $response->object();

        if ($data === null) {
            Log::error("AI returned null for candidate {$candidate->id}");

            return null;
        }

        return AnalysisData::fromArray($data);
    }
}
