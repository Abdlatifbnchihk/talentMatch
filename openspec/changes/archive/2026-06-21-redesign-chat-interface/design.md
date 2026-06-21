## Context

The current `chat/show.blade.php` is a basic full-page layout with a simple message list and input field. HR agents need a professional, focused environment for discussing candidates with AI — similar to Claude or ChatGPT. The candidate context should be always visible, and the interface should support tool call visualization, suggested questions, and a polished message thread.

Current state:
- Single-column layout with header and basic message list
- No candidate context sidebar
- No suggested questions
- Tool calls not visualized
- Basic textarea input

## Goals / Non-Goals

**Goals:**
- Full-height two-panel layout (sidebar + chat area)
- Left sidebar with candidate context card, required skills, suggested questions
- Right panel with chat header, scrollable message thread, sticky input bar
- Tool call blocks with collapsible raw output
- Typing indicator during AI response
- Auto-growing textarea with Enter/Shift+Enter support
- Timestamps on hover only
- "Powered by Claude via laravel/ai" subtle label

**Non-Goals:**
- No backend changes (controller, routes, models)
- No new dependencies (Tailwind + vanilla JS only)
- No real-time streaming (future enhancement)
- No conversation history sidebar (future enhancement)

## Decisions

1. **Two-panel layout with CSS flexbox** — Left panel fixed 280px, right panel flex-1. Uses `calc(100vh - navbar)` for full height. Alternative considered: CSS Grid. Flexbox chosen for simpler horizontal split.

2. **Suggested questions as clickable chips** — Pre-defined questions that pre-fill the input. Alternative considered: dropdown menu. Chips chosen for visibility and quick access.

3. **Tool call blocks with `<details>` element** — Native HTML collapsible without JS. Alternative considered: Alpine.js toggle. Native chosen for zero dependencies.

4. **Auto-growing textarea with JS** — Listen to `input` event, adjust height based on scrollHeight, max 4 lines. Alternative considered: CSS `resize: none` with fixed height. Auto-grow chosen for better UX.

5. **Typing indicator with CSS animation** — Three bouncing dots using `@keyframes`. No JS animation library needed.

## Risks / Trade-offs

- [Sidebar takes horizontal space on small screens] → Hide sidebar on mobile (< 1024px), show only chat area
- [Suggested questions are hardcoded] → Acceptable for MVP, can be made dynamic later
- [No real-time streaming yet] → Typing indicator is a placeholder for future streaming support
