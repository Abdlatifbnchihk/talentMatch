<?php

namespace App\Policies;

use App\Models\JobOffer;
use App\Models\User;

class JobOfferPolicy
{
    /**
     * Determine whether the user can view the job offer.
     */
    public function view(User $user, JobOffer $jobOffer): bool
    {
        return $user->id === $jobOffer->user_id;
    }

    /**
     * Determine whether the user can update the job offer.
     */
    public function update(User $user, JobOffer $jobOffer): bool
    {
        return $user->id === $jobOffer->user_id;
    }

    /**
     * Determine whether the user can delete the job offer.
     */
    public function delete(User $user, JobOffer $jobOffer): bool
    {
        return $user->id === $jobOffer->user_id;
    }
}
