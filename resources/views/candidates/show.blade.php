<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Candidate Analysis') }}
            </h2>
            <a href="{{ route('offers.show', $offer) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('Back to Offer') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Header Section --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $candidate->name }}</h1>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Job Offer:') }} {{ $offer->title }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('Submitted:') }} {{ $candidate->created_at->format('M d, Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Main Content (2 columns) --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Score Widget --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            @php
                                $score = $analysis->matching_score;
                                $scoreColor = $score >= 70 ? 'green' : ($score >= 40 ? 'amber' : 'red');
                                $scoreBg = match($scoreColor) {
                                    'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
                                    'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-6 py-3 rounded-full text-3xl font-bold {{ $scoreBg }}">
                                {{ $score }}/100
                            </span>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('Matching Score') }}</p>
                        </div>
                    </div>

                    {{-- Recommendation Pill --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Recommendation') }}</h3>
                            @php
                                $recColor = match($analysis->recommendation->badgeColor()) {
                                    'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'amber' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
                                    'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                };
                            @endphp
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $recColor }}">
                                {{ $analysis->recommendation->label() }}
                            </span>
                        </div>
                    </div>

                    {{-- Three Column Grid: Strengths, Gaps, Missing Skills --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        {{-- Strengths --}}
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    {{ __('Strengths') }}
                                </h3>
                                <ul class="space-y-2">
                                    @foreach($analysis->strengths as $strength)
                                        <li class="text-sm text-gray-900 dark:text-gray-100 flex items-start">
                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $strength }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Gaps --}}
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    {{ __('Gaps') }}
                                </h3>
                                <ul class="space-y-2">
                                    @foreach($analysis->gaps as $gap)
                                        <li class="text-sm text-gray-900 dark:text-gray-100 flex items-start">
                                            <svg class="w-4 h-4 mr-2 mt-0.5 text-amber-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            {{ $gap }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{-- Missing Skills --}}
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Missing Skills') }}</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($analysis->missing_skills as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Justification Block --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Justification') }}</h3>
                            <p class="text-sm text-gray-900 dark:text-gray-100 leading-relaxed">{{ $analysis->justification }}</p>
                        </div>
                    </div>
                </div>

                {{-- Sidebar --}}
                <div class="space-y-6">
                    {{-- Experience & Education --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">{{ __('Details') }}</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Years of Experience') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $analysis->years_experience }} {{ __('years') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">{{ __('Education Level') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $analysis->education_level }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    {{-- Extracted Skills --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Extracted Skills') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($analysis->extracted_skills as $skill)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        {{ $skill }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Languages --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">{{ __('Languages') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($analysis->languages as $language)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $language }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
