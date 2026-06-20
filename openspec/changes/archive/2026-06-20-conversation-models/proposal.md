## Why

TalentMatch needs an AI chat assistant that lets users ask follow-up questions about a candidate's analysis (e.g., "Why did you recommend rejecting?", "What skills should they improve?"). This requires persisting conversations and messages between users and the AI.

## What Changes

- New `conversations` table and `Conversation` model (FKs to `candidates` and `users`, nullable `title`)
- New `messages` table and `Message` model (FK to `conversations`, `role` enum, `content` text, `tool_calls` JSON nullable, immutable — only `created_at`)
- New `App\Enums\MessageRole` enum (`user`, `assistant`, `tool`)
- `Candidate` model gains `hasMany(Conversation::class)`
- `User` model gains `hasMany(Conversation::class)`

## Capabilities

### New Capabilities
- `conversation-persistence`: Stores and retrieves chat conversations and messages between users and the AI assistant for a given candidate.

### Modified Capabilities
- `candidate-analysis`: No spec changes — only a new `hasMany` relationship added to the Candidate model (implementation detail, not a behavior change).

## Impact

- New files: `app/Models/Conversation.php`, `app/Models/Message.php`, `app/Enums/MessageRole.php`, two migrations
- Modified files: `app/Models/Candidate.php`, `app/Models/User.php`
- Database: two new tables (`conversations`, `messages`)
