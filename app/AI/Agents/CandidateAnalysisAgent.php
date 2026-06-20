<?php

namespace App\AI\Agents;

use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\StructuredAnonymousAgent;

#[Provider('groq')]
#[Model('llama-3.3-70b-versatile')]
class CandidateAnalysisAgent extends StructuredAnonymousAgent
{
    public function __construct()
    {
        parent::__construct(
            instructions: 'You are an expert HR analyst. Analyze the candidate CV against the job offer and provide a structured JSON analysis. The recommendation must be one of: convoquer, attente, rejeter.',
            messages: [],
            tools: [],
            schema: function ($schema) {
                return [
                    'extracted_skills' => $schema->array()->items($schema->string()),
                    'years_experience' => $schema->integer(),
                    'education_level' => $schema->string(),
                    'languages' => $schema->array()->items($schema->string()),
                    'matching_score' => $schema->integer()->min(0)->max(100),
                    'strengths' => $schema->array()->items($schema->string()),
                    'gaps' => $schema->array()->items($schema->string()),
                    'missing_skills' => $schema->array()->items($schema->string()),
                    'recommendation' => $schema->string(),
                    'justification' => $schema->string(),
                ];
            },
        );
    }
}
