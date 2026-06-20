<?php

namespace App\AI\Tools;

use App\Models\Candidate;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class CompareCandidatesTool implements Tool
{
    public function description(): string
    {
        return 'Compare two analyzed candidates';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'candidate_id_1' => $schema->integer(),
            'candidate_id_2' => $schema->integer(),
        ];
    }

    public function handle(Request $request): string
    {
        $id1 = $request['candidate_id_1'];
        $id2 = $request['candidate_id_2'];

        $candidate1 = Candidate::with(['latestAnalysis', 'jobOffer'])->find($id1);
        $candidate2 = Candidate::with(['latestAnalysis', 'jobOffer'])->find($id2);

        if (! $candidate1) {
            return "Error: Candidate with ID {$id1} not found.";
        }

        if (! $candidate2) {
            return "Error: Candidate with ID {$id2} not found.";
        }

        if (! $candidate1->latestAnalysis) {
            return "Error: Candidate '{$candidate1->name}' has not been analyzed yet.";
        }

        if (! $candidate2->latestAnalysis) {
            return "Error: Candidate '{$candidate2->name}' has not been analyzed yet.";
        }

        $a1 = $candidate1->latestAnalysis;
        $a2 = $candidate2->latestAnalysis;

        $scoreDiff = abs($a1->matching_score - $a2->matching_score);
        $better = $a1->matching_score > $a2->matching_score
            ? $candidate1->name
            : ($a2->matching_score > $a1->matching_score ? $candidate2->name : 'Tie');

        return json_encode([
            'candidate_1' => [
                'name' => $candidate1->name,
                'score' => $a1->matching_score,
                'recommendation' => $a1->recommendation->value,
                'strengths' => $a1->strengths,
                'gaps' => $a1->gaps,
                'missing_skills' => $a1->missing_skills,
            ],
            'candidate_2' => [
                'name' => $candidate2->name,
                'score' => $a2->matching_score,
                'recommendation' => $a2->recommendation->value,
                'strengths' => $a2->strengths,
                'gaps' => $a2->gaps,
                'missing_skills' => $a2->missing_skills,
            ],
            'score_diff' => $scoreDiff,
            'better_candidate' => $better,
        ]);
    }
}
