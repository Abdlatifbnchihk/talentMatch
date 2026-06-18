<?php

namespace Tests\Feature;

use App\Models\JobOffer;
use App\Models\User;
use Tests\TestCase;

class JobOfferPolicyTest extends TestCase
{
    /**
     * Test that owners can view their offers.
     */
    public function test_owner_can_view_own_offer(): void
    {
        $user = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('offers.show', $offer))
            ->assertOk();
    }

    /**
     * Test that non-owners cannot view offers they don't own.
     */
    public function test_non_owner_cannot_view_offer(): void
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($nonOwner)
            ->get(route('offers.show', $offer))
            ->assertForbidden();
    }

    /**
     * Test that owners can edit their offers.
     */
    public function test_owner_can_edit_own_offer(): void
    {
        $user = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('offers.edit', $offer))
            ->assertOk();
    }

    /**
     * Test that non-owners cannot edit offers they don't own.
     */
    public function test_non_owner_cannot_edit_offer(): void
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($nonOwner)
            ->get(route('offers.edit', $offer))
            ->assertForbidden();
    }

    /**
     * Test that owners can update their offers.
     */
    public function test_owner_can_update_own_offer(): void
    {
        $user = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put(route('offers.update', $offer), [
                'title' => 'Updated Title',
                'description' => 'Updated Description',
                'required_skills' => ['PHP', 'Laravel'],
                'min_experience_years' => 3,
            ])
            ->assertRedirect(route('offers.show', $offer));
    }

    /**
     * Test that non-owners cannot update offers they don't own.
     */
    public function test_non_owner_cannot_update_offer(): void
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($nonOwner)
            ->put(route('offers.update', $offer), [
                'title' => 'Updated Title',
                'description' => 'Updated Description',
                'required_skills' => ['PHP', 'Laravel'],
                'min_experience_years' => 3,
            ])
            ->assertForbidden();
    }

    /**
     * Test that owners can delete their offers.
     */
    public function test_owner_can_delete_own_offer(): void
    {
        $user = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->delete(route('offers.destroy', $offer))
            ->assertRedirect(route('offers.index'));
    }

    /**
     * Test that non-owners cannot delete offers they don't own.
     */
    public function test_non_owner_cannot_delete_offer(): void
    {
        $owner = User::factory()->create();
        $nonOwner = User::factory()->create();
        $offer = JobOffer::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($nonOwner)
            ->delete(route('offers.destroy', $offer))
            ->assertForbidden();
    }
}
