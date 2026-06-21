<?php

namespace App\Http\Controllers;

use App\AI\Tools\CompareCandidatesTool;
use App\AI\Tools\GetCandidateAnalysisTool;
use App\AI\Tools\GetJobRequirementsTool;
use App\Enums\MessageRole;
use App\Http\Requests\StoreChatMessageRequest;
use App\Models\Candidate;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\AnonymousAgent;

class ChatController extends Controller
{
    private const SYSTEM_PROMPT = <<<'PROMPT'
You are TalentMatch AI assistant, helping HR agents evaluate candidates.
You have access to tools for fetching candidate analysis, job requirements, and comparing candidates.

You are in a conversation about a specific candidate. The candidate's ID, name, and job title are provided below. Always use the provided candidate ID when calling tools — never ask the user for it.

When answering:
- Be concise and professional
- Reference specific data from analyses
- Use the candidate's name when discussing them
- If the user asks about the candidate, use GetCandidateAnalysis with the provided ID directly
- If the user asks about job requirements, use GetJobRequirements with the provided job ID directly
- If comparing candidates, ask for the other candidate's ID only
Respond in the same language the user writes in.
PROMPT;

    public function show(Candidate $candidate)
    {
        $conversation = Conversation::firstOrCreate([
            'candidate_id' => $candidate->id,
            'user_id' => Auth::id(),
        ], [
            'title' => "Discussion about {$candidate->name}",
        ]);

        $messages = $conversation->messages()->orderBy('created_at')->get();

        return view('chat.show', compact('candidate', 'conversation', 'messages'));
    }

    public function message(StoreChatMessageRequest $request, Candidate $candidate)
    {
        $conversation = Conversation::firstOrCreate([
            'candidate_id' => $candidate->id,
            'user_id' => Auth::id(),
        ], [
            'title' => "Discussion about {$candidate->name}",
        ]);

        $userMessage = $request->validated('content');

        Message::create([
            'conversation_id' => $conversation->id,
            'role' => MessageRole::User,
            'content' => $userMessage,
        ]);

        $history = $conversation->messages()
            ->orderBy('created_at')
            ->get()
            ->map(fn (Message $msg) => [
                'role' => $msg->role->value,
                'content' => $msg->content,
            ])
            ->toArray();

        $agent = new AnonymousAgent(
            instructions: self::SYSTEM_PROMPT . "\n\nCurrent candidate: ID={$candidate->id}, Name={$candidate->name}, Job={$candidate->jobOffer->title}",
            messages: $history,
            tools: [
                new GetCandidateAnalysisTool(),
                new GetJobRequirementsTool(),
                new CompareCandidatesTool(),
            ],
        );

        try {
            $response = $agent->prompt($userMessage);

            Message::create([
                'conversation_id' => $conversation->id,
                'role' => MessageRole::Assistant,
                'content' => $response->text,
            ]);

            return response()->json([
                'reply' => $response->text,
            ]);
        } catch (\Throwable $e) {
            Log::error('Chat AI error: ' . $e->getMessage(), [
                'exception' => $e,
                'candidate_id' => $candidate->id,
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'reply' => 'Error: ' . $e->getMessage(),
            ]);
        }
    }
}
