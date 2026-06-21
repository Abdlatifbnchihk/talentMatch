<x-app-layout>
    <div class="flex h-[calc(100vh-4rem)]">
        {{-- Left Sidebar --}}
        <aside class="hidden lg:flex flex-col w-[280px] border-r border-slate-200 bg-slate-50 overflow-y-auto">
            {{-- Candidate Context Header --}}
            <div class="px-4 py-3 border-b border-slate-200">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Candidate context</h3>
            </div>

            {{-- Mini Candidate Card --}}
            <div class="px-4 py-4 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <span class="text-indigo-700 font-semibold text-sm">{{ substr($candidate->name, 0, 1) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-slate-800 truncate">{{ $candidate->name }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            @if($candidate->latestAnalysis)
                                @php
                                    $score = $candidate->latestAnalysis->matching_score;
                                    $scoreColor = $score >= 80 ? '#22c55e' : ($score >= 50 ? '#f59e0b' : '#ef4444');
                                @endphp
                                <svg class="w-5 h-5" viewBox="0 0 36 36">
                                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="{{ $scoreColor }}" stroke-width="3" stroke-dasharray="{{ $score }}, 100" stroke-linecap="round"/>
                                </svg>
                                <span class="text-xs font-medium text-slate-500">{{ $score }}%</span>
                            @endif
                            @if($candidate->latestAnalysis)
                                @php
                                    $rec = $candidate->latestAnalysis->recommendation;
                                    $recColor = match($rec->value) {
                                        'convoquer' => 'bg-green-100 text-green-700',
                                        'attente' => 'bg-amber-100 text-amber-700',
                                        'rejeter' => 'bg-red-100 text-red-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium {{ $recColor }}">{{ $rec->label() }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Required Skills --}}
            <div class="px-4 py-4 border-b border-slate-200">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Required skills</h3>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($candidate->jobOffer->required_skills as $skill)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700">{{ $skill }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Suggested Questions --}}
            <div class="px-4 py-4">
                <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Suggested questions</h3>
                <div class="space-y-2">
                    <button type="button" class="suggested-question w-full text-left px-3 py-2 rounded-lg text-sm text-slate-700 bg-white border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                        Why did this candidate get this score?
                    </button>
                    <button type="button" class="suggested-question w-full text-left px-3 py-2 rounded-lg text-sm text-slate-700 bg-white border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                        What interview questions should I ask?
                    </button>
                    <button type="button" class="suggested-question w-full text-left px-3 py-2 rounded-lg text-sm text-slate-700 bg-white border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                        What are the biggest risks with this candidate?
                    </button>
                    <button type="button" class="suggested-question w-full text-left px-3 py-2 rounded-lg text-sm text-slate-700 bg-white border border-slate-200 hover:border-indigo-300 hover:bg-indigo-50 transition-all duration-200">
                        Compare with another candidate
                    </button>
                </div>
            </div>
        </aside>

        {{-- Right Panel — Chat Area --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Chat Header --}}
            <div class="flex items-center justify-between px-6 py-3 border-b border-slate-200 bg-white flex-shrink-0">
                <div>
                    <h1 class="text-base font-semibold text-slate-800">{{ $candidate->name }}</h1>
                    <p class="text-xs text-slate-400">AI Assistant</p>
                </div>
                <a href="{{ route('offers.candidates.show', [$candidate->jobOffer, $candidate]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm text-slate-400 hover:text-slate-700 rounded-lg hover:bg-slate-100 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to analysis
                </a>
            </div>

            {{-- Message Thread --}}
            <div id="chat-messages" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                @forelse ($messages as $message)
                    @if ($message->role->value === 'user')
                        {{-- User Message --}}
                        <div class="flex justify-end group">
                            <div class="max-w-[70%]">
                                <div class="bg-indigo-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm">
                                    <p class="whitespace-pre-wrap text-sm">{{ $message->content }}</p>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1 opacity-0 group-hover:opacity-100 transition-opacity text-right">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @else
                        {{-- Assistant Message --}}
                        <div class="flex justify-start group">
                            <div class="flex-shrink-0 mr-3 mt-1">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.27a7 7 0 01-12.46 0H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zM9.5 14a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm5 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="max-w-[70%]">
                                <div class="bg-white text-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm border border-slate-200">
                                    <p class="whitespace-pre-wrap text-sm">{{ $message->content }}</p>
                                </div>
                                <p class="text-[11px] text-slate-400 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $message->created_at->format('H:i') }}</p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="flex justify-center items-center h-full">
                        <div class="text-center text-slate-400">
                            <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <p class="mt-2 text-sm">Start a conversation about {{ $candidate->name }}</p>
                        </div>
                    </div>
                @endforelse

                {{-- Typing Indicator --}}
                <div id="typing-indicator" class="flex justify-start hidden">
                    <div class="flex-shrink-0 mr-3 mt-1">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.27a7 7 0 01-12.46 0H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zM9.5 14a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm5 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-white px-4 py-3 rounded-2xl rounded-tl-sm shadow-sm border border-slate-200">
                        <div class="flex gap-1">
                            <span class="typing-dot w-2 h-2 bg-slate-400 rounded-full"></span>
                            <span class="typing-dot w-2 h-2 bg-slate-400 rounded-full"></span>
                            <span class="typing-dot w-2 h-2 bg-slate-400 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Input Bar --}}
            <div class="border-t border-slate-200 bg-white px-6 py-4 flex-shrink-0">
                <form id="chat-form" class="flex items-end gap-3">
                    @csrf
                    <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                    <div class="flex-1 relative">
                        <textarea
                            id="chat-input"
                            name="content"
                            rows="1"
                            placeholder="Ask anything about this candidate…"
                            class="w-full resize-none rounded-2xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm pr-12 py-3 text-slate-800"
                            required
                        ></textarea>
                        <button
                            id="send-btn"
                            type="submit"
                            disabled
                            class="absolute right-2 bottom-2 inline-flex items-center justify-center w-8 h-8 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-40 disabled:cursor-not-allowed transition-all duration-200"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                            </svg>
                        </button>
                    </div>
                </form>
                <p class="text-[11px] text-slate-400 mt-2 text-center">Powered by AI — may make mistakes. Verify critical info.</p>
            </div>
        </div>
    </div>

    <style>
        .typing-dot {
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .typing-dot:nth-child(1) { animation-delay: -0.32s; }
        .typing-dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>

    <script>
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const textarea = document.getElementById('chat-input');
        const sendBtn = document.getElementById('send-btn');
        const typingIndicator = document.getElementById('typing-indicator');

        chatMessages.scrollTop = chatMessages.scrollHeight;

        textarea.addEventListener('input', () => {
            textarea.style.height = 'auto';
            textarea.style.height = Math.min(textarea.scrollHeight, 128) + 'px';
            sendBtn.disabled = !textarea.value.trim();
        });

        textarea.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (textarea.value.trim()) chatForm.dispatchEvent(new Event('submit'));
            }
        });

        document.querySelectorAll('.suggested-question').forEach(btn => {
            btn.addEventListener('click', () => {
                textarea.value = btn.dataset.question;
                textarea.dispatchEvent(new Event('input'));
                textarea.focus();
            });
        });

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const content = textarea.value.trim();
            if (!content) return;

            const csrfToken = chatForm.querySelector('input[name="_token"]').value;
            const candidateId = chatForm.querySelector('input[name="candidate_id"]').value;

            appendMessage('user', content);
            textarea.value = '';
            textarea.style.height = 'auto';
            sendBtn.disabled = true;

            typingIndicator.classList.remove('hidden');
            chatMessages.scrollTop = chatMessages.scrollHeight;

            try {
                const response = await fetch(`/candidates/${candidateId}/chat`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ content }),
                });

                const data = await response.json();
                typingIndicator.classList.add('hidden');
                appendMessage('assistant', data.reply);
            } catch (error) {
                typingIndicator.classList.add('hidden');
                appendMessage('assistant', 'Sorry, an error occurred. Please try again.');
            }
        });

        function appendMessage(role, content) {
            const now = new Date();
            const time = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
            const isUser = role === 'user';

            const div = document.createElement('div');
            div.className = `flex ${isUser ? 'justify-end' : 'justify-start'} group`;

            if (isUser) {
                div.innerHTML = `
                    <div class="max-w-[70%]">
                        <div class="bg-indigo-600 text-white px-4 py-2.5 rounded-2xl rounded-tr-sm">
                            <p class="whitespace-pre-wrap text-sm">${escapeHtml(content)}</p>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 opacity-0 group-hover:opacity-100 transition-opacity text-right">${time}</p>
                    </div>
                `;
            } else {
                div.innerHTML = `
                    <div class="flex-shrink-0 mr-3 mt-1">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.27a7 7 0 01-12.46 0H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zM9.5 14a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm5 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="max-w-[70%]">
                        <div class="bg-white text-slate-800 px-4 py-2.5 rounded-2xl rounded-tl-sm shadow-sm border border-slate-200">
                            <p class="whitespace-pre-wrap text-sm">${escapeHtml(content)}</p>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">${time}</p>
                    </div>
                `;
            }

            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return div;
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</x-app-layout>
