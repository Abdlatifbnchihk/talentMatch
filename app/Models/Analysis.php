<?php

namespace App\Models;

use App\Enums\Recommendation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Analysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'extracted_skills',
        'years_experience',
        'education_level',
        'languages',
        'matching_score',
        'strengths',
        'gaps',
        'missing_skills',
        'recommendation',
        'justification',
    ];

    protected $casts = [
        'extracted_skills' => 'array',
        'languages' => 'array',
        'strengths' => 'array',
        'gaps' => 'array',
        'missing_skills' => 'array',
        'matching_score' => 'integer',
        'recommendation' => Recommendation::class,
    ];

    /**
     * Get the candidate that owns the analysis.
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
