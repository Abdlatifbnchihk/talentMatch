<x-app-layout>
    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">My Job Offers</h1>
        <a href="{{ route('offers.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Post a new offer
        </a>
    </div>

    {{-- Filter/Search Row --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex gap-6 border-b border-slate-200">
            <button onclick="filterOffers('all')" class="offer-tab pb-2 text-sm font-medium border-b-2 transition-all duration-200 border-indigo-600 text-indigo-600" data-filter="all">All</button>
            <button onclick="filterOffers('active')" class="offer-tab pb-2 text-sm font-medium border-b-2 transition-all duration-200 border-transparent text-slate-400 hover:text-slate-600" data-filter="active">Active</button>
            <button onclick="filterOffers('closed')" class="offer-tab pb-2 text-sm font-medium border-b-2 transition-all duration-200 border-transparent text-slate-400 hover:text-slate-600" data-filter="closed">Closed</button>
        </div>
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="search-offers" placeholder="Search offers..." onkeyup="searchOffers()"
                class="pl-9 pr-4 py-2 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200 w-64">
        </div>
    </div>

    @if ($offers->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-16">
            <svg class="w-16 h-16 text-indigo-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-medium text-slate-600 mb-2">No job offers yet</h3>
            <a href="{{ route('offers.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-indigo-700 transition-all duration-200">
                Post your first offer
            </a>
        </div>
    @else
        {{-- Offers Grid --}}
        <div id="offers-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($offers as $offer)
                <div class="offer-card bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden transition-all duration-200 hover:shadow-md group"
                    data-status="{{ $offer->status->value }}" data-title="{{ strtolower($offer->title) }}">
                    {{-- Card Top --}}
                    <div class="p-5">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-indigo-700 font-semibold text-sm">TM</span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-800">{{ $offer->title }}</h3>
                                    <p class="text-sm text-slate-400 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Posted by {{ $offer->user->name ?? 'Unknown' }}
                                    </p>
                                </div>
                            </div>
                            {{-- Three-dot menu --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-1 w-36 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-10">
                                    <a href="{{ route('offers.edit', $offer) }}" class="block px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-all duration-200">Edit</a>
                                    <a href="{{ route('offers.show', $offer) }}" class="block px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 transition-all duration-200">View</a>
                                </div>
                            </div>
                        </div>

                        {{-- Pills --}}
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                Remote
                            </span>
                            @if($offer->min_experience_years)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    Min. {{ $offer->min_experience_years }} years exp
                                </span>
                            @endif
                        </div>

                        {{-- Skills --}}
                        <div class="flex flex-wrap gap-1.5 mt-3">
                            @foreach(array_slice($offer->required_skills ?? [], 0, 4) as $skill)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{ $skill }}</span>
                            @endforeach
                            @if(count($offer->required_skills ?? []) > 4)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">+{{ count($offer->required_skills) - 4 }} more</span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Footer --}}
                    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-sm text-slate-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $offer->candidates_count ?? 0 }} candidates
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $offer->status->value === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $offer->status->value === 'active' ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                            {{ ucfirst($offer->status->value) }}
                        </span>
                    </div>

                    {{-- Hover overlay --}}
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-white via-white to-transparent opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-200 pointer-events-none">
                        <a href="{{ route('offers.show', $offer) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">View candidates →</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $offers->links() }}
        </div>
    @endif

    <script>
        function filterOffers(status) {
            document.querySelectorAll('.offer-tab').forEach(tab => {
                tab.classList.remove('border-indigo-600', 'text-indigo-600');
                tab.classList.add('border-transparent', 'text-slate-400');
            });
            document.querySelector(`[data-filter="${status}"]`).classList.add('border-indigo-600', 'text-indigo-600');
            document.querySelector(`[data-filter="${status}"]`).classList.remove('border-transparent', 'text-slate-400');

            document.querySelectorAll('.offer-card').forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function searchOffers() {
            const query = document.getElementById('search-offers').value.toLowerCase();
            document.querySelectorAll('.offer-card').forEach(card => {
                const title = card.dataset.title;
                card.style.display = title.includes(query) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>
