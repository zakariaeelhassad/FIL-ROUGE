<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show list of all chats for the current user
    public function index()
    {
        $userId = Auth::id();
        
        // Get all chats where the current user is either user_one or user_two
        $chats = Chat::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo', 'latestMessage'])
            ->get();
        
        return view('components.chat.index', compact('chats'));
    }

    // Show a specific chat conversation
    public function show(Chat $chat)
    {
        // Check if the authenticated user is part of this chat
        if (!$chat->hasUser(Auth::id())) {
            abort(403, 'Unauthorized');
        }
        
        // Get the other user in the conversation
        $otherUser = $chat->getOtherUser(Auth::id());
        
        // Get all messages for this chat
        $messages = $chat->messages()
            ->with(['sender', 'receiver'])
            ->orderBy('created_at')
            ->get();
        
        // Mark unread messages as read
        $chat->messages()
            ->where('receiver_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);
        
        return view('components.chat.show', compact('chat', 'messages', 'otherUser'));
    }

    // Store a new message
    public function store(Request $request, Chat $chat)
{
    try {
        // Validate request
        $request->validate([
            'message' => 'required|string',
        ]);
        
        // Check if the authenticated user is part of this chat
        if (!$chat->hasUser(Auth::id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        // Get the other user (receiver)
        $receiverId = $chat->getOtherUser(Auth::id())->id;
        
        // Create the message
        $message = $chat->messages()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);
        
        // Load the sender relationship
        $message->load('sender');
        
        // Broadcast the event
        broadcast(new NewMessage($message))->toOthers();
        
        return response()->json([
            'status' => 'Message sent!',
            'message' => $message
        ]);
    } catch (\Exception $e) {
        // Log the error
        Log::error('Chat message error: ' . $e->getMessage());
        
        // Return a JSON error response
        return response()->json([
            'error' => 'An error occurred while sending your message',
            'details' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}

    // Create a new chat with another user
    public function create(Request $request)
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('components.chat.create', compact('users'));
    }

    // Store a new chat
    public function storeChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $userId = Auth::id();
        $otherUserId = $request->user_id;
        
        // Check if a chat already exists between these users
        $chat = Chat::where(function($query) use ($userId, $otherUserId) {
                $query->where('user_one_id', $userId)
                      ->where('user_two_id', $otherUserId);
            })
            ->orWhere(function($query) use ($userId, $otherUserId) {
                $query->where('user_one_id', $otherUserId)
                      ->where('user_two_id', $userId);
            })
            ->first();
        
        // If no chat exists, create one
        if (!$chat) {
            $chat = Chat::create([
                'user_one_id' => $userId,
                'user_two_id' => $otherUserId,
            ]);
        }
        
        return redirect()->route('chat.show', $chat);
    }
}