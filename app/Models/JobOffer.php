<?php

namespace App\Models;

use App\Enums\JobOfferStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'description', 'required_skills', 'min_experience_years', 'status'])]
class JobOffer extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'required_skills' => 'array',
            'min_experience_years' => 'integer',
            'status' => JobOfferStatus::class,
        ];
    }

    /**
     * Get the user that owns the job offer.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the candidates for the job offer.
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
