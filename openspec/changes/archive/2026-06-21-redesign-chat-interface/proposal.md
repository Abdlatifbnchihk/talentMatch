## Why

The current chat interface is a basic full-page layout with minimal UX. HR agents need a professional, focused environment for discussing candidates with AI — similar to Claude or ChatGPT — with candidate context always visible, suggested questions for quick access, and a polished message thread with tool call visualization.

## What Changes

- Redesign `chat/show.blade.php` as a full-height two-panel layout
- Add left sidebar with candidate context card, required skills, and suggested questions
- Add right panel with chat header, scrollable message thread, and sticky input bar
- Implement tool call result blocks with collapsible raw output
- Add typing indicator animation during AI response
- Add auto-growing textarea with Enter/Shift+Enter support
- Show timestamps on hover only
- Add "Powered by Claude via laravel/ai" subtle label

## Capabilities

### New Capabilities
- `chat-ui-redesign`: Full-height two-panel chat layout with candidate context sidebar, suggested questions, enhanced message thread with tool call blocks, typing indicator, and auto-grow input

### Modified Capabilities
- (none — this is a view-only redesign, no spec-level behavior changes)

## Impact

- **Files modified**: `resources/views/chat/show.blade.php`
- **Dependencies**: Tailwind CSS (already in use), vanilla JS (no new deps)
- **No API changes**: Controller and routes remain the same
- **No model changes**: Data flow unchanged
