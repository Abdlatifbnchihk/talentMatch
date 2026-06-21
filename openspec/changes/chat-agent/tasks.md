## 1. Routes and Form Request

- [x] 1.1 Add `GET /candidates/{candidate}/chat` and `POST /candidates/{candidate}/chat` routes to `routes/web.php`
- [x] 1.2 Create `StoreChatMessageRequest` with `content` required|string|max:2000

## 2. ChatController

- [x] 2.1 Create `ChatController` with `show` method: load or create conversation for candidate+user, load messages, render `chat.show` view
- [x] 2.2 Create `ChatController` with `message` method: validate via `StoreChatMessageRequest`, persist user message
- [x] 2.3 In `message`: build messages array from conversation history, call AI agent with system prompt + tools + history
- [x] 2.4 In `message`: persist assistant reply as Message, persist any tool calls as Message, return JSON `{ reply }`
- [x] 2.5 Add system prompt constant and tool references to controller

## 3. Chat View

- [x] 3.1 Create `resources/views/chat/show.blade.php` layout: header with candidate name + "AI Assistant"
- [x] 3.2 Add message thread: user messages right-aligned, assistant messages left-aligned with avatar icon
- [x] 3.3 Add collapsible info blocks for tool call results
- [x] 3.4 Add input area: textarea + send button at bottom
- [x] 3.5 Add fetch-based submission: POST to chat endpoint, append reply to thread, auto-scroll to bottom

## 4. Verification

- [x] 4.1 Verify routes are registered: `php artisan route:list --path=chat`
- [x] 4.2 Verify chat page loads for a candidate with an existing conversation
- [x] 4.3 Verify sending a message persists user message and returns AI reply
