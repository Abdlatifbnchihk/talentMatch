## ADDED Requirements

### Requirement: Full-height two-panel layout
The chat page SHALL display as a full-height two-panel layout with a left sidebar and right chat area.

#### Scenario: Layout renders full height
- **WHEN** user navigates to `/candidates/{candidate}/chat`
- **THEN** page fills the viewport below the navbar with no outer page scroll

#### Scenario: Left sidebar width
- **WHEN** layout renders on desktop (≥ 1024px)
- **THEN** left panel is 280px wide and right panel fills remaining space

#### Scenario: Mobile layout
- **WHEN** layout renders on mobile (< 1024px)
- **THEN** left sidebar is hidden and chat area fills full width

### Requirement: Candidate context sidebar
The left sidebar SHALL display candidate context information.

#### Scenario: Candidate context header
- **WHEN** sidebar renders
- **THEN** it shows "Candidate context" as section header

#### Scenario: Mini candidate card
- **WHEN** sidebar renders
- **THEN** it shows a mini card with candidate avatar (first letter), name, small score ring, and recommendation pill

#### Scenario: Required skills section
- **WHEN** sidebar renders
- **THEN** it shows "Required skills" header with job offer skills as pills

#### Scenario: Suggested questions section
- **WHEN** sidebar renders
- **THEN** it shows "Suggested questions" header with clickable chips for pre-defined questions

#### Scenario: Suggested question pre-fills input
- **WHEN** user clicks a suggested question chip
- **THEN** the question text is inserted into the chat input field and input gains focus

### Requirement: Chat header bar
The right panel SHALL display a header bar with candidate info and navigation.

#### Scenario: Header content
- **WHEN** chat area renders
- **THEN** it shows candidate name + "AI Assistant" label on the left and "Back to analysis" ghost button on the right

### Requirement: Message thread
The chat area SHALL display messages in a scrollable thread.

#### Scenario: User messages
- **WHEN** a user message is displayed
- **THEN** it is right-aligned with indigo background, white text, and rounded-2xl rounded-tr-sm

#### Scenario: Assistant messages
- **WHEN** an assistant message is displayed
- **THEN** it is left-aligned with white card, subtle shadow, slate text, and AI avatar icon top-left

#### Scenario: Tool call blocks
- **WHEN** a tool call is made by the assistant
- **THEN** it displays a dashed border card with code-like font showing "🔧 Called: toolName(args)" and is collapsible to show raw result

#### Scenario: Timestamps on hover
- **WHEN** user hovers over a message
- **THEN** the timestamp becomes visible

#### Scenario: Smooth scroll to bottom
- **WHEN** a new message is added to the thread
- **THEN** the thread smoothly scrolls to the bottom

### Requirement: Input bar
The chat area SHALL display a sticky input bar at the bottom.

#### Scenario: Input bar positioning
- **WHEN** chat renders
- **THEN** input bar is sticky at the bottom with white background and top border

#### Scenario: Auto-growing textarea
- **WHEN** user types multi-line text
- **THEN** textarea grows from 1 to 4 lines max then shows scrollbar

#### Scenario: Enter submits Shift+Enter newlines
- **WHEN** user presses Enter
- **THEN** message is submitted; WHEN user presses Shift+Enter, newline is inserted

#### Scenario: Send button state
- **WHEN** input is empty
- **THEN** send button is disabled; WHEN input has text, send button is enabled

#### Scenario: Powered by label
- **WHEN** input bar renders
- **THEN** it shows "Powered by Claude via laravel/ai" subtle label below the input

### Requirement: Typing indicator
The chat area SHALL display a typing indicator while waiting for AI response.

#### Scenario: Loading state
- **WHEN** user sends a message and waits for AI reply
- **THEN** an animated typing indicator (three bouncing dots) is displayed

#### Scenario: Indicator disappears
- **WHEN** AI response is received
- **THEN** typing indicator is replaced by the assistant message
