<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('offers.index') }}" class="hover:text-slate-600 transition-all duration-200">Offers</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('offers.show', $offer) }}" class="hover:text-slate-600 transition-all duration-200">{{ $offer->title }}</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">{{ $candidate->name }}</span>
    </div>

    @php
        $score = $analysis->matching_score;
        $scoreColor = $score >= 70 ? 'green' : ($score >= 40 ? 'amber' : 'red');
        $scoreStroke = $score >= 70 ? '#4f46e5' : ($score >= 40 ? '#f59e0b' : '#ef4444');
    @endphp

    {{-- Row 1: Two columns --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">
        {{-- Score Card (60%) --}}
        <div class="lg:col-span-3 bg-white border border-slate-200 rounded-xl shadow-sm p-8 text-center">
            {{-- Donut Ring --}}
            <div class="relative inline-block">
                <svg class="w-40 h-40" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{{ $scoreStroke }}" stroke-width="3" stroke-dasharray="{{ $score }}, 100" stroke-linecap="round"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-4xl font-bold text-slate-800">{{ $score }}</span>
                </div>
            </div>
            <p class="text-sm text-slate-400 mt-2">Matching score</p>

            {{-- Recommendation Pill --}}
            <div class="mt-6">
                @php
                    $rec = $analysis->recommendation;
                    $recClass = match($rec->value) {
                        'convoquer' => 'bg-green-100 text-green-700',
                        'attente' => 'bg-amber-100 text-amber-700',
                        'rejeter' => 'bg-red-100 text-red-700',
                    };
                @endphp
                <span class="inline-flex items-center gap-2 px-6 py-2 rounded-full text-sm font-semibold {{ $recClass }}">
                    @if($rec->value === 'convoquer')
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    @elseif($rec->value === 'attente')
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    @endif
                    {{ $rec->label() }}
                </span>
            </div>

            {{-- Chat Button --}}
            <a href="{{ route('candidates.chat.show', $candidate) }}" class="mt-6 inline-flex items-center justify-center gap-2 w-full bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-700 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Open chat assistant →
            </a>
        </div>

        {{-- Info Card (40%) --}}
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-8">
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center">
                    <span class="text-indigo-700 font-semibold text-xl">{{ substr($candidate->name, 0, 1) }}</span>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mt-3">{{ $candidate->name }}</h2>
            </div>

            <div class="mt-6 space-y-4">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <div>
                        <p class="text-xs text-slate-400">Education</p>
                        <p class="text-sm font-medium text-slate-800">{{ $analysis->education_level }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <div>
                        <p class="text-xs text-slate-400">Experience</p>
                        <p class="text-sm font-medium text-slate-800">{{ $analysis->years_experience }} years</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                    <div>
                        <p class="text-xs text-slate-400">Languages</p>
                        <p class="text-sm font-medium text-slate-800">{{ implode(', ', $analysis->languages) }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-slate-400 mb-2">Extracted skills</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach($analysis->extracted_skills as $skill)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{ $skill }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Row 2: Three columns --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Strengths --}}
        <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-slate-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                Strengths
            </h3>
            <ul class="space-y-2">
                @foreach($analysis->strengths as $strength)
                    <li class="text-sm text-slate-700 flex items-start gap-2">
                        <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $strength }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Gaps --}}
        <div class="bg-amber-50 border-l-4 border-amber-500 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-slate-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                Gaps
            </h3>
            <ul class="space-y-2">
                @foreach($analysis->gaps as $gap)
                    <li class="text-sm text-slate-700 flex items-start gap-2">
                        <svg class="w-4 h-4 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        {{ $gap }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Missing Skills --}}
        <div class="bg-red-50 border-l-4 border-red-500 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-slate-800 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                Missing skills
            </h3>
            <div class="flex flex-wrap gap-1.5">
                @foreach($analysis->missing_skills as $skill)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Row 3: Justification --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-8 border-l-4 border-indigo-400">
        <h3 class="text-sm font-semibold text-slate-800 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            AI Justification
        </h3>
        <p class="text-sm text-slate-600 leading-relaxed italic pl-4">{{ $analysis->justification }}</p>
    </div>
</x-app-layout>
