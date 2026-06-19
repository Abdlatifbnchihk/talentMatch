<?php

namespace App\Jobs;

use App\Enums\CandidateStatus;
use App\Models\Analysis;
use App\Models\Candidate;
use App\Services\CandidateAnalysisService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeCandidateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 90;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Candidate $candidate
    ) {
        $this->queue = 'ai-analysis';
    }

    /**
     * Execute the job.
     */
    public function handle(CandidateAnalysisService $analysisService): void
    {
        try {
            $result = $analysisService->analyze($this->candidate);

            if ($result === null) {
                Log::error("CandidateAnalysisService returned null for candidate {$this->candidate->id}");
                $this->fail();

                return;
            }

            Analysis::create([
                'candidate_id' => $this->candidate->id,
                'extracted_skills' => $result->extracted_skills,
                'years_experience' => $result->years_experience,
                'education_level' => $result->education_level,
                'languages' => $result->languages,
                'matching_score' => $result->matching_score,
                'strengths' => $result->strengths,
                'gaps' => $result->gaps,
                'missing_skills' => $result->missing_skills,
                'recommendation' => $result->recommendation,
                'justification' => $result->justification,
            ]);

            $this->candidate->update(['status' => CandidateStatus::Analyzed]);
        } catch (\Exception $e) {
            Log::error("Analysis failed for candidate {$this->candidate->id}: {$e->getMessage()}");
            $this->fail($e);
        }
    }
}
