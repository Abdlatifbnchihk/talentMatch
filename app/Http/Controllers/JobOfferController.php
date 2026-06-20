<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobOfferRequest;
use App\Http\Requests\UpdateJobOfferRequest;
use App\Models\JobOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $offers = auth()->user()->offers()->withCount('candidates')->latest()->paginate(10);

        return view('offers.index', compact('offers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobOfferRequest $request): RedirectResponse
    {
        $offer = auth()->user()->offers()->create($request->validated());

        return redirect()->route('offers.show', $offer);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOffer $offer): View
    {
        $this->authorize('view', $offer);

        $offer->load('candidates.latestAnalysis');

        return view('offers.show', compact('offer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOffer $offer): View
    {
        $this->authorize('update', $offer);

        return view('offers.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobOfferRequest $request, JobOffer $offer): RedirectResponse
    {
        $this->authorize('update', $offer);

        $offer->update($request->validated());

        return redirect()->route('offers.show', $offer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOffer $offer): RedirectResponse
    {
        $this->authorize('delete', $offer);

        $offer->delete();

        return redirect()->route('offers.index');
    }
}
