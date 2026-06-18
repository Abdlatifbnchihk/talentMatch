<?php

namespace App\Models;

use App\Enums\CandidateStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cv_text', 'status', 'job_offer_id'];

    protected $casts = [
        'status' => CandidateStatus::class,
    ];

    /**
     * Get the job offer that owns the candidate.
     */
    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class);
    }

    /**
     * Get the analysis for the candidate.
     */
    public function analysis()
    {
        return $this->hasOne(CandidateAnalysis::class);
    }
}