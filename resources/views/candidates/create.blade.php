<x-app-layout>
    <div class="max-w-2xl mx-auto">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
            <a href="{{ route('offers.index') }}" class="hover:text-slate-600 transition-all duration-200">Offers</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('offers.show', $offer) }}" class="hover:text-slate-600 transition-all duration-200">{{ $offer->title }}</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-600">Submit candidate</span>
        </div>

        {{-- Offer Context Card --}}
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5 mb-6">
            <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600 mb-1">You are submitting against:</p>
            <h2 class="text-lg font-semibold text-slate-800">{{ $offer->title }}</h2>
            <div class="flex flex-wrap gap-1.5 mt-2">
                @php
                    $raw = $offer->required_skills;
                    $skills = is_array($raw) ? $raw : (is_string($raw) ? array_filter(array_map('trim', explode(',', $raw))) : []);
                @endphp
                @foreach(array_slice($skills, 0, 4) as $skill)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{ $skill }}</span>
                @endforeach
            </div>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 mt-2">
                Min. {{ $offer->min_experience_years }} years experience
            </span>
        </div>

        {{-- Form Card --}}
        <form action="{{ route('offers.candidates.store', $offer) }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm p-8">
            @csrf

            {{-- Section 1: Candidate Info --}}
            <div class="mb-8">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-4">👤 Candidate Info</h3>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255"
                            class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                            placeholder="Candidate's full name">
                    </div>
                    @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Section 2: CV Content --}}
            <div class="mb-8">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-4">📄 CV Content</h3>

                <label class="block text-sm font-medium text-slate-700 mb-1">Paste the candidate's full CV</label>
                <p class="text-sm text-slate-400 mb-2">Plain text — copy from PDF, Word, or LinkedIn profile</p>

                <textarea name="cv_text" id="cv_text" rows="12" required minlength="50"
                    class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200 min-h-64 font-mono text-sm leading-relaxed"
                    placeholder="Paste CV content here..." oninput="updateCharCount()">{{ old('cv_text') }}</textarea>

                <div class="flex justify-between items-center mt-1">
                    <button type="button" onclick="toggleTips()" class="text-xs text-slate-400 hover:text-slate-600 flex items-center gap-1 transition-all duration-200">
                        <svg id="tips-chevron" class="w-3 h-3 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        💡 Tips for best results
                    </button>
                    <span id="cv-char-count" class="text-xs text-slate-400">0 characters</span>
                </div>

                <div id="tips-panel" class="hidden mt-2 p-3 bg-slate-50 rounded-lg text-xs text-slate-600 leading-relaxed">
                    <p class="font-medium mb-1">For best results include:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Work history with exact dates</li>
                        <li>Skills listed explicitly</li>
                        <li>Education and certifications</li>
                        <li>Project descriptions with tech stack</li>
                    </ul>
                </div>

                @error('cv_text') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>

            {{-- Form Footer --}}
            <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                <a href="{{ route('offers.show', $offer) }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50 transition-all duration-200">
                    Cancel
                </a>
                <div class="text-right">
                    <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Analyze candidate
                    </button>
                    <p class="text-xs text-slate-400 mt-1">Analysis usually completes in 5–10 seconds</p>
                </div>
            </div>
        </form>
    </div>

    <script>
        function updateCharCount() {
            const len = document.getElementById('cv_text').value.length;
            document.getElementById('cv-char-count').textContent = len + ' characters';
        }

        function toggleTips() {
            const panel = document.getElementById('tips-panel');
            const chevron = document.getElementById('tips-chevron');
            panel.classList.toggle('hidden');
            chevron.classList.toggle('rotate-180');
        }
    </script>
</x-app-layout>
