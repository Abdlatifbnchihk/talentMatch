<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Jobs\AnalyzeCandidateJob;
use App\Models\Candidate;
use App\Models\JobOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CandidateController extends Controller
{
    /**
     * Display a listing of candidates for the authenticated user's offers.
     */
    public function index(): View
    {
        $candidates = Candidate::whereHas('jobOffer', function ($query) {
            $query->where('user_id', auth()->id());
        })
            ->with('jobOffer')
            ->latest()
            ->paginate(15);

        return view('candidates.index', compact('candidates'));
    }

    /**
     * Show the form for creating a new candidate for a job offer.
     */
    public function create(JobOffer $offer): View
    {
        return view('candidates.create', compact('offer'));
    }

    /**
     * Store a newly created candidate in storage.
     */
    public function store(StoreCandidateRequest $request, JobOffer $offer): RedirectResponse
    {
        $candidate = $offer->candidates()->create($request->validated());

        AnalyzeCandidateJob::dispatch($candidate);

        return redirect()->route('offers.show', $offer)
            ->with('success', 'Candidate submitted successfully!');
    }

    /**
     * Show the analysis detail for a candidate.
     */
    public function show(JobOffer $offer, Candidate $candidate): View
    {
        $candidate->load('analysis');

        return view('candidates.show', compact('offer', 'candidate'));
    }

    /**
     * Show the form for editing the specified candidate.
     */
    public function edit(JobOffer $offer, Candidate $candidate): View
    {
        return view('candidates.edit', compact('offer', 'candidate'));
    }

    /**
     * Update the specified candidate in storage.
     */
    public function update(StoreCandidateRequest $request, JobOffer $offer, Candidate $candidate): RedirectResponse
    {
        $candidate->update($request->validated());

        return redirect()->route('offers.candidates.show', [$offer, $candidate])
            ->with('success', 'Candidate updated successfully!');
    }

    /**
     * Remove the specified candidate from storage.
     */
    public function destroy(JobOffer $offer, Candidate $candidate): RedirectResponse
    {
        $candidate->delete();

        return redirect()->route('offers.show', $offer)
            ->with('success', 'Candidate deleted successfully!');
    }
}