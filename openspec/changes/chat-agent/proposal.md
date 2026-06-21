## Why

HR agents need an interactive chat assistant to ask follow-up questions about candidates, prepare interview questions, and compare candidates in real-time. The infrastructure is ready: conversation/message models exist, AI tools are built. What's missing is the controller, routes, view, and the glue that connects them.

## What Changes

- New `ChatController` with `show` (render chat page) and `message` (send message, get AI reply) actions
- New `StoreChatMessageRequest` form request for message validation
- New routes: `GET /candidates/{candidate}/chat`, `POST /candidates/{candidate}/chat`
- New `chat/show.blade.php` view with message thread, input, and fetch-based submission
- AI agent integration using `laravel/ai` with the three existing tools

## Capabilities

### New Capabilities
- `chat-agent`: Full conversational chat interface connecting users to the AI agent with tool-calling support and conversation history.

### Modified Capabilities
- `conversation-persistence`: Minor — no spec changes, only new controller/view consuming existing models
- `agent-tools`: Minor — no spec changes, only new controller wiring existing tools

## Impact

- New files: `app/Http/Controllers/ChatController.php`, `app/Http/Requests/StoreChatMessageRequest.php`, `resources/views/chat/show.blade.php`
- Modified files: `routes/web.php` (2 new routes)
- Dependencies: `conversation-persistence` and `agent-tools` changes must be implemented first
