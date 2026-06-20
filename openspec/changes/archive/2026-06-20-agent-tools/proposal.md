## Why

The chat assistant needs to answer follow-up questions about candidates (e.g., "Compare Ahmed vs Sara", "What are the requirements for the UI designer role?"). Without structured AI tools, the assistant cannot query candidate data, job requirements, or perform comparisons. Tool calling lets the AI fetch real data during conversation instead of hallucinating answers.

## What Changes

- New `App\AI\Tools\GetCandidateAnalysisTool` — fetches full analysis for a candidate by ID
- New `App\AI\Tools\GetJobRequirementsTool` — fetches job offer requirements by ID
- New `App\AI\Tools\CompareCandidatesTool` — compares two analyzed candidates side-by-side
- All tools implement `Laravel\Ai\Contracts\Tool` interface

## Capabilities

### New Capabilities
- `agent-tools`: Three AI agent tools that give the chat assistant structured access to candidate analyses, job requirements, and candidate comparison data.

### Modified Capabilities

## Impact

- New files: `app/AI/Tools/GetCandidateAnalysisTool.php`, `app/AI/Tools/GetJobRequirementsTool.php`, `app/AI/Tools/CompareCandidatesTool.php`
- No database changes
- No existing code changes — tools are consumed by the agent in a future change
