## 1. Layout Structure

- [x] 1.1 Replace existing `chat/show.blade.php` with full-height two-panel flex layout (`calc(100vh - navbar)`)
- [x] 1.2 Add left sidebar container (280px, hidden on < 1024px)
- [x] 1.3 Add right panel container (flex-1, flex-col)

## 2. Left Sidebar — Candidate Context

- [x] 2.1 Add "Candidate context" section header
- [x] 2.2 Build mini candidate card: avatar circle (first letter), name, small score ring SVG, recommendation pill
- [x] 2.3 Add "Required skills" section with job offer skills as pills
- [x] 2.4 Add "Suggested questions" section with 4 clickable chips
- [x] 2.5 Wire chip click to pre-fill chat input and focus

## 3. Right Panel — Chat Header

- [x] 3.1 Add sticky top bar with candidate name + "AI Assistant" label
- [x] 3.2 Add "Back to analysis" ghost button on right side of header

## 4. Right Panel — Message Thread

- [x] 4.1 Build scrollable message container (flex-1, overflow-y-auto)
- [x] 4.2 Style user messages: right-aligned, indigo bg, white text, rounded-2xl rounded-tr-sm
- [x] 4.3 Style assistant messages: left-aligned, white card, shadow, slate text, AI avatar icon
- [x] 4.4 Build tool call blocks: dashed border card, code font, "🔧 Called: toolName(args)", `<details>` collapsible for raw result
- [x] 4.5 Add timestamps (hidden by default, visible on hover via group-hover)
- [x] 4.6 Add smooth scroll-to-bottom on new message via JS

## 5. Right Panel — Input Bar

- [x] 5.1 Build sticky bottom input bar: white bg, top border
- [x] 5.2 Add auto-growing textarea (1–4 lines, JS input event listener)
- [x] 5.3 Handle Enter to submit, Shift+Enter for newline
- [x] 5.4 Add send button: indigo, arrow-up icon, disabled when empty
- [x] 5.5 Add "Powered by Claude via laravel/ai" subtle label below input

## 6. Typing Indicator

- [x] 6.1 Create typing indicator component: three bouncing dots with CSS keyframes
- [x] 6.2 Show indicator after user sends message, hide when reply arrives

## 7. Mobile Responsiveness

- [x] 7.1 Hide left sidebar on screens < 1024px
- [x] 7.2 Ensure chat area fills full width on mobile

## 8. Verification

- [x] 8.1 Verify page renders full height with no outer scroll
- [x] 8.2 Verify suggested question chips pre-fill input
- [x] 8.3 Verify tool call blocks are collapsible
- [x] 8.4 Verify typing indicator shows during AI response
- [x] 8.5 Verify auto-growing textarea respects 4-line max
