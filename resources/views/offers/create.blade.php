<x-app-layout>
    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-6">
        <a href="{{ route('offers.index') }}" class="hover:text-slate-600 transition-all duration-200">Offers</a>
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
        <span class="text-slate-600">Create new offer</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Form Column --}}
        <div class="flex-1 lg:w-[65%]">
            <form action="{{ route('offers.store') }}" method="POST" class="bg-white border border-slate-200 rounded-xl shadow-sm p-8">
                @csrf

                {{-- Section 1: Job Details --}}
                <div class="mb-8">
                    <h3 class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-4">📋 Job Details</h3>

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required maxlength="200"
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                            placeholder="e.g. Senior Laravel Developer" oninput="updatePreview()">
                        @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full px-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200 min-h-40"
                            placeholder="Describe the role, responsibilities, and requirements..." oninput="updatePreview(); updateCharCount()"></textarea>
                        <div class="flex justify-end mt-1">
                            <span id="char-count" class="text-xs text-slate-400">0 / 2000</span>
                        </div>
                        @error('description') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
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
                            <span id="experience-label" class="text-sm font-medium text-slate-800 min-w-[60px] text-center">0 years</span>
                            <button type="button" onclick="updateExperience(1)" class="w-10 h-10 rounded-full border border-slate-300 flex items-center justify-center text-slate-600 hover:bg-slate-50 transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                            </button>
                        </div>
                        <input type="hidden" name="min_experience_years" id="min_experience_years" value="{{ old('min_experience_years', 0) }}">
                    </div>
                </div>

                {{-- Form Footer --}}
                <div class="flex items-center justify-between pt-6 border-t border-slate-200">
                    <a href="{{ route('offers.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 border border-slate-300 rounded-lg hover:bg-slate-50 transition-all duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Publish offer
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
                                <h3 id="preview-title" class="text-lg font-semibold text-slate-800">Job title</h3>
                                <p class="text-sm text-slate-400">Posted by {{ Auth::user()->name ?? 'You' }}</p>
                            </div>
                        </div>
                        <p id="preview-description" class="text-sm text-slate-500 mt-3 line-clamp-3">Job description will appear here...</p>
                        <div id="preview-skills" class="flex flex-wrap gap-1.5 mt-3">
                            <span class="text-xs text-slate-400">Skills will appear here</span>
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-sm text-slate-500">0 candidates</span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Active
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Skills tag input
        const skills = [];
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
        let experience = {{ old('min_experience_years', 0) }};
        function updateExperience(delta) {
            experience = Math.max(0, experience + delta);
            document.getElementById('min_experience_years').value = experience;
            document.getElementById('experience-label').textContent = experience + ' years';
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
        }
    </script>
</x-app-layout>
