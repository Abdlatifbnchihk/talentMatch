<?php

namespace App\AI\Tools;

use App\Models\JobOffer;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class GetJobRequirementsTool implements Tool
{
    public function description(): string
    {
        return 'Fetch the job offer requirements by offer ID';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'job_offer_id' => $schema->integer(),
        ];
    }

    public function handle(Request $request): string
    {
        $offer = JobOffer::find($request['job_offer_id']);

        if (! $offer) {
            return 'Error: Job offer not found.';
        }

        return json_encode([
            'title' => $offer->title,
            'description' => $offer->description,
            'required_skills' => $offer->required_skills,
            'min_experience_years' => $offer->min_experience_years,
            'status' => $offer->status->value,
        ]);
    }
}
