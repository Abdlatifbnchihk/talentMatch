<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('offers.index') }}" class="hover:text-slate-600 transition-all duration-200">Offers</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">Edit offer</span>
    </div>

    @php
        $skillsArray = is_array($offer->required_skills) ? $offer->required_skills : [];
    @endphp

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Form Column --}}
        <div class="flex-1 lg:w-[65%]">
            <form action="{{ route('offers.update', $offer) }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm p-8">
                @csrf
                @method('PUT')

                {{-- Section 1: Job Details --}}
                <div class="mb-8">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-4">📋 Job Details</h3>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $offer->title) }}" required maxlength="200"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                            oninput="updatePreview()">
                        @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200 min-h-40"
                            oninput="updatePreview(); updateCharCount()">{{ old('description', $offer->description) }}</textarea>
                        <div class="flex justify-end mt-1">
                            <span id="char-count" class="text-xs text-slate-400">{{ strlen($offer->description) }} / 2000</span>
                        </div>
                        @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status Toggle --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <div class="flex items-center gap-3">
                            <button type="button" id="status-toggle" onclick="toggleStatus()" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 {{ old('status', $offer->status->value) === 'active' ? 'bg-indigo-600' : 'bg-slate-300' }}">
                                <span id="status-dot" class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200 {{ old('status', $offer->status->value) === 'active' ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                            <span id="status-label" class="text-sm font-medium text-slate-700">{{ old('status', $offer->status->value) === 'active' ? 'Active' : 'Closed' }}</span>
                        </div>
                        <input type="hidden" name="status" id="status-input" value="{{ old('status', $offer->status->value) }}">
                    </div>
                </div>

                {{-- Section 2: Requirements --}}
                <div class="mb-8">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-4">🛠 Requirements</h3>

                    {{-- Skills Tag Input --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Skills</label>
                        <div id="skills-container" class="flex flex-wrap gap-2 p-2 border border-slate-200 rounded-lg min-h-[42px] focus-within:border-indigo-400 focus-within:ring-indigo-400 transition-all duration-200">
                            <input type="text" id="skill-input" class="flex-1 min-w-[120px] px-2 py-1 text-sm border-0 focus:ring-0 focus:outline-none" placeholder="Type a skill and press Enter...">
                        </div>
                        <div id="skills-tags" class="hidden"></div>
                        @error('required_skills') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Experience Stepper --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Minimum Experience</label>
                        <div class="flex items-center gap-4">
                            <button type="button" onclick="updateExperience(-1)" class="w-10 h-10 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                            </button>
                            <span id="experience-label" class="text-sm font-medium text-slate-800 min-w-[60px] text-center">{{ $offer->min_experience_years }} years</span>
                            <button type="button" onclick="updateExperience(1)" class="w-10 h-10 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                        <input type="hidden" name="min_experience_years" id="min_experience_years" value="{{ old('min_experience_years', $offer->min_experience_years) }}">
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                    <a href="{{ route('offers.show', $offer) }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Update offer
                    </button>
                </div>
            </form>
        </div>

        {{-- Live Preview Column --}}
        <div class="hidden lg:block lg:w-[35%]">
            <div class="sticky top-24">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-3">👁 Preview</p>
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-indigo-700 font-semibold text-sm">TM</span>
                            </div>
                            <div>
                                <h3 id="preview-title" class="text-lg font-semibold text-slate-800">{{ $offer->title }}</h3>
                                <p class="text-sm text-slate-400">Posted by {{ $offer->user->name ?? 'Unknown' }}</p>
                            </div>
                        </div>
                        <p id="preview-description" class="text-sm text-slate-500 mt-3 line-clamp-3">{{ Str::limit($offer->description, 150) }}</p>
                        <div id="preview-skills" class="flex flex-wrap gap-1.5 mt-3">
                            @foreach(array_slice($skillsArray, 0, 4) as $skill)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-sm text-slate-500">{{ $offer->candidates_count ?? 0 }} candidates</span>
                        <span id="preview-status" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $offer->status->value === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-500' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $offer->status->value === 'active' ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                            {{ ucfirst($offer->status->value) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize skills from existing data
        const skills = @json($skillsArray);
        renderSkills();

        const skillInput = document.getElementById('skill-input');
        const skillsContainer = document.getElementById('skills-container');
        const skillsTags = document.getElementById('skills-tags');

        skillInput.addEventListener('keydown', (e) => {
            if ((e.key === 'Enter' || e.key === ',') && skillInput.value.trim()) {
                e.preventDefault();
                addSkill(skillInput.value.trim().replace(',', ''));
            }
        });

        function addSkill(skill) {
            if (skills.includes(skill)) return;
            skills.push(skill);
            renderSkills();
            skillInput.value = '';
            updatePreview();
        }

        function removeSkill(skill) {
            const idx = skills.indexOf(skill);
            if (idx > -1) skills.splice(idx, 1);
            renderSkills();
            updatePreview();
        }

        function renderSkills() {
            skillsContainer.querySelectorAll('.skill-tag').forEach(el => el.remove());
            skills.forEach(skill => {
                const tag = document.createElement('span');
                tag.className = 'skill-tag inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700';
                tag.innerHTML = `${skill} <button type="button" onclick="removeSkill('${skill}')" class="hover:text-indigo-900">&times;</button>`;
                skillsContainer.insertBefore(tag, skillInput);
            });
            skillsTags.innerHTML = skills.map(s => `<input type="hidden" name="required_skills[]" value="${s}">`).join('');
        }

        // Experience stepper
        let experience = {{ $offer->min_experience_years }};
        function updateExperience(delta) {
            experience = Math.max(0, experience + delta);
            document.getElementById('min_experience_years').value = experience;
            document.getElementById('experience-label').textContent = experience + ' years';
            updatePreview();
        }

        // Status toggle
        let currentStatus = '{{ $offer->status->value }}';
        function toggleStatus() {
            currentStatus = currentStatus === 'active' ? 'closed' : 'active';
            document.getElementById('status-input').value = currentStatus;
            const toggle = document.getElementById('status-toggle');
            const dot = document.getElementById('status-dot');
            const label = document.getElementById('status-label');
            if (currentStatus === 'active') {
                toggle.classList.remove('bg-slate-300');
                toggle.classList.add('bg-indigo-600');
                dot.classList.remove('translate-x-1');
                dot.classList.add('translate-x-6');
                label.textContent = 'Active';
            } else {
                toggle.classList.remove('bg-indigo-600');
                toggle.classList.add('bg-slate-300');
                dot.classList.remove('translate-x-6');
                dot.classList.add('translate-x-1');
                label.textContent = 'Closed';
            }
            updatePreview();
        }

        // Character count
        function updateCharCount() {
            const len = document.getElementById('description').value.length;
            document.getElementById('char-count').textContent = len + ' / 2000';
        }

        // Live preview
        function updatePreview() {
            const title = document.getElementById('title').value || 'Job title';
            const desc = document.getElementById('description').value || 'Job description will appear here...';
            document.getElementById('preview-title').textContent = title;
            document.getElementById('preview-description').textContent = desc.substring(0, 150) + (desc.length > 150 ? '...' : '');

            const skillsHtml = skills.length > 0
                ? skills.slice(0, 4).map(s => `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">${s}</span>`).join('')
                + (skills.length > 4 ? `<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500">+${skills.length - 4} more</span>` : '')
                : '<span class="text-xs text-slate-400">Skills will appear here</span>';
            document.getElementById('preview-skills').innerHTML = skillsHtml;

            const statusEl = document.getElementById('preview-status');
            if (currentStatus === 'active') {
                statusEl.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700';
                statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active';
            } else {
                statusEl.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-500';
                statusEl.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Closed';
            }
        }
    </script>
</x-app-layout>
