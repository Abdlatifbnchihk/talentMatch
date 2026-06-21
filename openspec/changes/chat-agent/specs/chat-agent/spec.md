## ADDED Requirements

### Requirement: Chat page display
The system SHALL render a chat page at `GET /candidates/{candidate}/chat` for authenticated users. The page SHALL display the candidate name, a message thread, and an input area.

#### Scenario: Open chat for new candidate
- **WHEN** an authenticated user opens the chat page for a candidate with no existing conversation
- **THEN** a new conversation is created for that candidate and user, and the chat page renders with an empty message thread

#### Scenario: Open chat for existing conversation
- **WHEN** an authenticated user opens the chat page for a candidate with an existing conversation
- **THEN** the chat page renders with all previous messages in chronological order

### Requirement: Send message and receive AI reply
The system SHALL accept a user message at `POST /candidates/{candidate}/chat` and return the AI agent's reply as JSON.

#### Scenario: User sends a message
- **WHEN** an authenticated user submits a message with `content` = "What are Ahmed's strengths?"
- **THEN** the system persists a `messages` row with `role = 'user'` and `content = 'What are Ahmed's strengths?'`

#### Scenario: AI agent responds
- **WHEN** the system persists the user message and calls the AI agent
- **THEN** the system persists an assistant message with the AI's response content, and returns JSON `{ "reply": "<assistant message content>" }`

#### Scenario: AI agent uses a tool
- **WHEN** the AI agent invokes a tool (e.g., GetCandidateAnalysisTool) during response generation
- **THEN** the system persists a tool message with the tool result, and the final assistant reply is also persisted and returned in the JSON response

### Requirement: Message validation
The system SHALL validate incoming chat messages using `StoreChatMessageRequest`. The `content` field SHALL be required, a string, and maximum 2000 characters.

#### Scenario: Valid message
- **WHEN** a user submits a message with `content` = "Compare Ahmed and Sara" (length < 2000)
- **THEN** the message is accepted and processed

#### Scenario: Empty message
- **WHEN** a user submits a message with `content` = ""
- **THEN** the system returns a 422 validation error

#### Scenario: Message too long
- **WHEN** a user submits a message with `content` exceeding 2000 characters
- **THEN** the system returns a 422 validation error

### Requirement: Conversation history for AI context
The system SHALL pass the full conversation message history to the AI agent on each request, enabling contextual multi-turn conversations.

#### Scenario: Multi-turn context
- **WHEN** a user asks "What are Ahmed's strengths?" and then asks "What about his gaps?"
- **THEN** the AI agent receives both messages in history and can answer the second question in context of the first

### Requirement: Chat UI layout
The view SHALL display a message thread with user messages right-aligned and assistant messages left-aligned with an avatar icon. Tool call results SHALL be shown as collapsible info blocks. An input textarea and send button SHALL be at the bottom. Messages SHALL auto-scroll to the bottom after submission.

#### Scenario: Message thread display
- **WHEN** a conversation has 3 messages (user, assistant, user)
- **THEN** the chat page shows user messages aligned right, assistant messages aligned left, in chronological order

#### Scenario: Auto-scroll
- **WHEN** the AI agent replies to a message
- **THEN** the page scrolls to the bottom of the message thread automatically
