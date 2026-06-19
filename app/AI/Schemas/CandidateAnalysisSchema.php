<?php

namespace App\AI\Schemas;

use Laravel\Ai\ObjectSchema;

class CandidateAnalysisSchema extends ObjectSchema
{
    public function __construct()
    {
        parent::__construct([
            'extracted_skills' => ['type' => 'array', 'items' => ['type' => 'string']],
            'years_experience' => ['type' => 'integer'],
            'education_level' => ['type' => 'string'],
            'languages' => ['type' => 'array', 'items' => ['type' => 'string']],
            'matching_score' => ['type' => 'integer', 'minimum' => 0, 'maximum' => 100],
            'strengths' => ['type' => 'array', 'items' => ['type' => 'string']],
            'gaps' => ['type' => 'array', 'items' => ['type' => 'string']],
            'missing_skills' => ['type' => 'array', 'items' => ['type' => 'string']],
            'recommendation' => ['type' => 'string', 'enum' => ['convoquer', 'attente', 'rejeter']],
            'justification' => ['type' => 'string'],
        ], name: 'candidate_analysis');
    }
}
