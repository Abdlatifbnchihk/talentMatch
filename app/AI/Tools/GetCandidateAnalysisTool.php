<?php

namespace App\AI\Tools;

use App\Models\Candidate;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class GetCandidateAnalysisTool implements Tool
{
    public function description(): string
    {
        return 'Fetch the full structured analysis for a candidate by their ID';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'candidate_id' => $schema->integer(),
        ];
    }

    public function handle(Request $request): string
    {
        $candidate = Candidate::with(['latestAnalysis', 'jobOffer'])
            ->find($request['candidate_id']);

        if (! $candidate) {
            return 'Error: Candidate not found.';
        }

        if (! $candidate->latestAnalysis) {
            return 'Error: This candidate has not been analyzed yet.';
        }

        $analysis = $candidate->latestAnalysis;

        return json_encode([
            'candidate_name' => $candidate->name,
            'job_offer_title' => $candidate->jobOffer->title,
            'extracted_skills' => $analysis->extracted_skills,
            'years_experience' => $analysis->years_experience,
            'education_level' => $analysis->education_level,
            'languages' => $analysis->languages,
            'matching_score' => $analysis->matching_score,
            'strengths' => $analysis->strengths,
            'gaps' => $analysis->gaps,
            'missing_skills' => $analysis->missing_skills,
            'recommendation' => $analysis->recommendation->value,
            'justification' => $analysis->justification,
        ]);
    }
}
