<?php

namespace App\Services;

use App\AI\DTOs\AnalysisData;
use App\Models\Candidate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CandidateAnalysisService
{
    private const SYSTEM_PROMPT = <<<'PROMPT'
You are an expert HR analyst. Analyze the candidate CV against the job offer.
Return ONLY a valid JSON object with no markdown or extra text. The JSON must contain these fields:
- extracted_skills: array of strings
- years_experience: integer
- education_level: string
- languages: array of strings
- matching_score: integer between 0 and 100
- strengths: array of strings
- gaps: array of strings
- missing_skills: array of strings
- recommendation: one of "convoquer", "attente", "rejeter"
- justification: string
PROMPT;

    /**
     * Analyze a candidate's CV against their job offer using AI.
     */
    public function analyze(Candidate $candidate): ?AnalysisData
    {
        $candidate->load('jobOffer');

        $jobOffer = $candidate->jobOffer;
        $skills = implode(', ', $jobOffer->required_skills ?? []);

        $userMessage = <<<MSG
JOB OFFER: {$jobOffer->title}
REQUIRED SKILLS: {$skills}
MINIMUM EXPERIENCE: {$jobOffer->min_experience_years} years
DESCRIPTION: {$jobOffer->description}

CANDIDATE CV:
{$candidate->cv_text}
MSG;

        $apiKey = config('services.groq.key', env('GROQ_API_KEY'));
        $baseUrl = 'https://api.groq.com/openai/v1';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->timeout(60)->post("{$baseUrl}/chat/completions", [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => self::SYSTEM_PROMPT],
                ['role' => 'user', 'content' => $userMessage],
            ],
            'temperature' => 0.3,
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            Log::error("Groq API error for candidate {$candidate->id}: " . $response->body());

            return null;
        }

        $content = $response->json('choices.0.message.content', '');
        $data = json_decode($content, true);

        if ($data === null || json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Invalid JSON from AI for candidate {$candidate->id}: {$content}");

            return null;
        }

        return AnalysisData::fromArray($data);
    }
}
