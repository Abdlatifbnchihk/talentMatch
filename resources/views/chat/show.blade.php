<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ $candidate->name }} — AI Assistant
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ $candidate->jobOffer->title }}
                </p>
            </div>
            <a href="{{ route('offers.candidates.show', [$candidate->jobOffer, $candidate]) }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back to candidate
            </a>
        </div>
    </x-slot>

    <div class="flex flex-col h-[calc(100vh-10rem)]">
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
            @forelse ($messages as $message)
                <div class="flex {{ $message->role->value === 'user' ? 'justify-end' : 'justify-start' }}">
                    @if ($message->role->value !== 'user')
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.27a7 7 0 01-12.46 0H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zM9.5 14a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm5 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                    <div class="max-w-[70%] {{ $message->role->value === 'user' ? 'bg-indigo-600 text-white rounded-l-xl rounded-tr-xl' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-r-xl rounded-tl-xl shadow' }} px-4 py-3">
                        <p class="whitespace-pre-wrap text-sm">{{ $message->content }}</p>
                        <p class="text-xs {{ $message->role->value === 'user' ? 'text-indigo-200' : 'text-gray-400 dark:text-gray-500' }} mt-1">
                            {{ $message->created_at->format('H:i') }}
                        </p>
                    </div>
                    @if ($message->role->value === 'user')
                        <div class="flex-shrink-0 ml-3">
                            <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="flex justify-center items-center h-full">
                    <div class="text-center text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="mt-2">Start a conversation about {{ $candidate->name }}</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
            <form id="chat-form" class="flex gap-3">
                @csrf
                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                <textarea
                    name="content"
                    rows="1"
                    placeholder="Ask about {{ $candidate->name }}..."
                    class="flex-1 resize-none rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                    required
                ></textarea>
                <button
                    type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <script>
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const textarea = chatForm.querySelector('textarea');

        chatMessages.scrollTop = chatMessages.scrollHeight;

        textarea.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                chatForm.dispatchEvent(new Event('submit'));
            }
        });

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const content = textarea.value.trim();
            if (!content) return;

            const csrfToken = chatForm.querySelector('input[name="_token"]').value;
            const candidateId = chatForm.querySelector('input[name="candidate_id"]').value;

            appendMessage('user', content);
            textarea.value = '';

            const loadingDiv = appendMessage('assistant', 'Thinking...');

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
                loadingDiv.querySelector('p').textContent = data.reply;
            } catch (error) {
                loadingDiv.querySelector('p').textContent = 'Sorry, an error occurred. Please try again.';
            }

            chatMessages.scrollTop = chatMessages.scrollHeight;
        });

        function appendMessage(role, content) {
            const now = new Date();
            const time = `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;
            const isUser = role === 'user';

            const div = document.createElement('div');
            div.className = `flex ${isUser ? 'justify-end' : 'justify-start'}`;

            const avatarHtml = isUser
                ? `<div class="flex-shrink-0 ml-3"><div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center"><span class="text-white text-sm font-medium">U</span></div></div>`
                : `<div class="flex-shrink-0 mr-3"><div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center"><svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a2 2 0 012 2c0 .74-.4 1.39-1 1.73V7h1a7 7 0 017 7h1a1 1 0 011 1v3a1 1 0 01-1 1h-1.27a7 7 0 01-12.46 0H3a1 1 0 01-1-1v-3a1 1 0 011-1h1a7 7 0 017-7h1V5.73c-.6-.34-1-.99-1-1.73a2 2 0 012-2zM9.5 14a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm5 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3z"/></svg></div></div>`;

            div.innerHTML = `
                ${avatarHtml}
                <div class="max-w-[70%] ${isUser ? 'bg-indigo-600 text-white rounded-l-xl rounded-tr-xl' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 rounded-r-xl rounded-tl-xl shadow'} px-4 py-3">
                    <p class="whitespace-pre-wrap text-sm">${content}</p>
                    <p class="text-xs ${isUser ? 'text-indigo-200' : 'text-gray-400 dark:text-gray-500'} mt-1">${time}</p>
                </div>
            `;

            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            return div;
        }
    </script>
</x-app-layout>
