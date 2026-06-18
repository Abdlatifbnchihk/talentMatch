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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Candidate Information --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('Candidate Information') }}</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $candidate->name }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $candidate->status->value === 'analyzed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($candidate->status->value) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Submitted') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $candidate->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Job Offer') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $offer->title }}</dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Analysis Results --}}
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('Analysis Results') }}</h3>
                            @if($candidate->analysis)
                                <dl class="space-y-4">
                                    {{-- Matching Score --}}
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Matching Score') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $candidate->analysis->matching_score >= 80 ? 'bg-green-100 text-green-800' : ($candidate->analysis->matching_score >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $candidate->analysis->matching_score }}%
                                            </span>
                                        </dd>
                                    </div>

                                    {{-- Recommendation --}}
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Recommendation') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                            @php
                                                $recommendationColors = [
                                                    'convoquer' => 'bg-green-100 text-green-800',
                                                    'attente' => 'bg-yellow-100 text-yellow-800',
                                                    'rejeter' => 'bg-red-100 text-red-800',
                                                ];
                                                $recommendationLabels = [
                                                    'convoquer' => 'Invite to interview',
                                                    'attente' => 'On hold',
                                                    'rejeter' => 'Reject',
                                                ];
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $recommendationColors[$candidate->analysis->recommendation->value] ?? '' }}">
                                                {{ $recommendationLabels[$candidate->analysis->recommendation->value] ?? ucfirst($candidate->analysis->recommendation->value) }}
                                            </span>
                                        </dd>
                                    </div>

                                    {{-- Experience --}}
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Years of Experience') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $candidate->analysis->years_experience }} {{ __('years') }}</dd>
                                    </div>

                                    {{-- Education --}}
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Education Level') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $candidate->analysis->education_level }}</dd>
                                    </div>

                                    {{-- Justification --}}
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Justification') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $candidate->analysis->justification }}</dd>
                                    </div>
                                </dl>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Analysis is pending...') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Skills Section (full width) --}}
                    @if($candidate->analysis)
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Extracted Skills --}}
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Extracted Skills') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($candidate->analysis->extracted_skills as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Languages --}}
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Languages') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($candidate->analysis->languages as $language)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $language }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Strengths --}}
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Strengths') }}</h4>
                                <ul class="list-disc list-inside text-sm text-gray-900 dark:text-gray-100 space-y-1">
                                    @foreach($candidate->analysis->strengths as $strength)
                                        <li>{{ $strength }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Gaps --}}
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Gaps') }}</h4>
                                <ul class="list-disc list-inside text-sm text-gray-900 dark:text-gray-100 space-y-1">
                                    @foreach($candidate->analysis->gaps as $gap)
                                        <li>{{ $gap }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Missing Skills --}}
                            <div class="md:col-span-2">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('Missing Skills') }}</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($candidate->analysis->missing_skills as $skill)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                            {{ $skill }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- CV Text --}}
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('CV Text') }}</h4>
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-md p-4 text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $candidate->cv_text }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>