<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('offers.index') }}" class="hover:text-slate-600 transition-all duration-200">Offers</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">{{ $offer->title }}</span>
    </div>

    {{-- Offer Header Card --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-8 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                    <span class="text-indigo-700 font-semibold text-lg">TM</span>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $offer->title }}</h1>
                    <p class="text-sm text-slate-400 flex items-center gap-1 mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Posted by {{ $offer->user->name ?? 'Unknown' }} · {{ $offer->created_at->format('M d, Y') }}
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium {{ $offer->status->value === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $offer->status->value === 'active' ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                    {{ ucfirst($offer->status->value) }}
                </span>
                <a href="{{ route('offers.candidates.create', $offer) }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-indigo-700 transition-all duration-200">
                    Submit a candidate
                </a>
            </div>
        </div>

        {{-- Skills --}}
        <div class="flex flex-wrap gap-1.5 mt-4">
            @php
                $raw = $offer->required_skills;
                $skills = is_array($raw) ? $raw : (is_string($raw) ? array_filter(array_map('trim', explode(',', $raw))) : []);
            @endphp
            @foreach($skills as $skill)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{ $skill }}</span>
            @endforeach
        </div>

        {{-- Description --}}
        <div class="mt-4">
            <p id="description-text" class="text-sm text-slate-600 leading-relaxed {{ Str::length($offer->description) > 200 ? 'line-clamp-3' : '' }}">{{ $offer->description }}</p>
            @if(Str::length($offer->description) > 200)
                <button onclick="toggleDescription()" class="text-sm text-indigo-600 hover:text-indigo-700 mt-1 transition-all duration-200">Read more</button>
            @endif
        </div>

        {{-- Stats Bar --}}
        @php
            $candidates = $offer->candidates;
            $total = $candidates->count();
            $avgScore = $total > 0 ? round($candidates->filter->latestAnalysis->avg('matching_score') ?? 0) : 0;
            $invited = $total > 0 ? round($candidates->filter->latestAnalysis->where('recommendation', 'convoquer')->count() / $total * 100) : 0;
            $rejected = $total > 0 ? round($candidates->filter->latestAnalysis->where('recommendation', 'rejeter')->count() / $total * 100) : 0;
        @endphp
        <div class="grid grid-cols-4 gap-4 mt-6 pt-6 border-t border-slate-200">
            <div class="text-center">
                <p class="text-2xl font-bold text-slate-800">{{ $total }}</p>
                <p class="text-xs text-slate-400">Total candidates</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-slate-800">{{ $avgScore }}</p>
                <p class="text-xs text-slate-400">Avg score</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-slate-800">{{ $invited }}%</p>
                <p class="text-xs text-slate-400">Invited</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-slate-800">{{ $rejected }}%</p>
                <p class="text-xs text-slate-400">Rejected</p>
            </div>
        </div>
    </div>

    {{-- Candidates Section --}}
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <h2 class="text-lg font-semibold text-slate-800">Candidates</h2>
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-slate-100 text-xs font-medium text-slate-600">{{ $total }}</span>
            </div>
            <div class="flex items-center gap-4">
                {{-- Tab Filters --}}
                <div class="flex gap-4 border-b border-slate-200">
                    <button onclick="filterCandidates('all')" class="candidate-tab pb-2 text-sm font-medium border-b-2 border-indigo-600 text-indigo-600 transition-all duration-200" data-filter="all">All</button>
                    <button onclick="filterCandidates('convoquer')" class="candidate-tab pb-2 text-sm font-medium border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all duration-200" data-filter="convoquer">Invite ≥70</button>
                    <button onclick="filterCandidates('attente')" class="candidate-tab pb-2 text-sm font-medium border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all duration-200" data-filter="attente">Hold 40-69</button>
                    <button onclick="filterCandidates('rejeter')" class="candidate-tab pb-2 text-sm font-medium border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all duration-200" data-filter="rejeter">Reject &lt;40</button>
                </div>
            </div>
        </div>
    </div>

    @if($candidates->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-12 bg-white border border-slate-200 rounded-xl">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <p class="text-slate-500">No candidates yet — be the first to submit a CV</p>
        </div>
    @else
        {{-- Candidate Table --}}
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-50">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">#</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Candidate</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Score</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Recommendation</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Status</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidates->sortByDesc('latestAnalysis.matching_score') as $candidate)
                        @php
                            $analysis = $candidate->latestAnalysis;
                            $score = $analysis->matching_score ?? null;
                            $rec = $analysis->recommendation ?? null;
                            $scoreColor = $score >= 70 ? 'green' : ($score >= 40 ? 'amber' : 'red');
                        @endphp
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition-all duration-200" data-score="{{ $score ?? 0 }}" data-rec="{{ $rec?->value ?? '' }}">
                            <td class="px-4 py-3 text-sm text-slate-400">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 {{ $scoreColor === 'green' ? 'bg-green-100' : ($scoreColor === 'amber' ? 'bg-amber-100' : 'bg-red-100') }}">
                                        <span class="font-medium text-sm {{ $scoreColor === 'green' ? 'text-green-700' : ($scoreColor === 'amber' ? 'text-amber-700' : 'text-red-700') }}">{{ substr($candidate->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">{{ $candidate->name }}</p>
                                        <p class="text-xs text-slate-400">Submitted {{ $candidate->created_at->format('M d') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($score !== null)
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $scoreColor === 'green' ? 'bg-green-500' : ($scoreColor === 'amber' ? 'bg-amber-500' : 'bg-red-500') }}" style="width: {{ $score }}%"></div>
                                        </div>
                                        <span class="text-sm text-slate-600">{{ $score }}/100</span>
                                    </div>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($rec)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ match($rec->value) { 'convoquer' => 'bg-green-100 text-green-700', 'attente' => 'bg-amber-100 text-amber-700', 'rejeter' => 'bg-red-100 text-red-700', default => 'bg-slate-100 text-slate-500' } }}">
                                        {{ $rec->label() }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($candidate->status->value === 'analyzed')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Analyzed
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('offers.candidates.show', [$offer, $candidate]) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-all duration-200">View</a>
                                    <a href="{{ route('candidates.chat.show', $candidate) }}" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-indigo-100 flex items-center justify-center transition-all duration-200">
                                        <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <script>
        function toggleDescription() {
            const el = document.getElementById('description-text');
            const btn = el.nextElementSibling;
            el.classList.toggle('line-clamp-3');
            btn.textContent = el.classList.contains('line-clamp-3') ? 'Read more' : 'Show less';
        }

        function filterCandidates(filter) {
            document.querySelectorAll('.candidate-tab').forEach(tab => {
                tab.classList.remove('border-indigo-600', 'text-indigo-600');
                tab.classList.add('border-transparent', 'text-slate-400');
            });
            document.querySelector(`[data-filter="${filter}"]`).classList.add('border-indigo-600', 'text-indigo-600');
            document.querySelector(`[data-filter="${filter}"]`).classList.remove('border-transparent', 'text-slate-400');

            document.querySelectorAll('tbody tr').forEach(row => {
                const score = parseInt(row.dataset.score);
                const rec = row.dataset.rec;
                let show = false;
                if (filter === 'all') show = true;
                else if (filter === 'convoquer') show = score >= 70;
                else if (filter === 'attente') show = score >= 40 && score < 70;
                else if (filter === 'rejeter') show = score < 40;
                row.style.display = show ? '' : 'none';
            });
        }
    </script>
</x-app-layout>
