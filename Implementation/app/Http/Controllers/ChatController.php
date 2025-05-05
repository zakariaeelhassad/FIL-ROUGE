<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\Follow;
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

    public function index()
{
    $userId = Auth::id();
    
    $chats = Chat::where('user_one_id', $userId)
        ->orWhere('user_two_id', $userId)
        ->with(['userOne', 'userTwo', 'latestMessage'])
        ->get()
        ->sortByDesc(function ($chat) {
            return optional($chat->latestMessage)->created_at;
        })
        ->values(); 

    return view('pages.chat.index', compact('chats'));
}


    public function show(Chat $chat)
    {
        if (!$chat->hasUser(Auth::id())) {
            abort(403, 'Unauthorized');
        }
        
        $otherUser = $chat->getOtherUser(Auth::id());
        
        $messages = $chat->messages()
            ->with(['sender', 'receiver'])
            ->orderBy('created_at')
            ->get();
        
        $chat->messages()
            ->where('receiver_id', Auth::id())
            ->where('read', false)
            ->update(['read' => true]);
        
        return view('pages.chat.show', compact('chat', 'messages', 'otherUser'));
    }

    public function store(Request $request, Chat $chat)
    {
        try {
            $request->validate([
                'message' => 'required|string',
            ]);
            
            if (!$chat->hasUser(Auth::id())) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            $receiverId = $chat->getOtherUser(Auth::id())->id;
            
            $message = $chat->messages()->create([
                'sender_id' => Auth::id(),
                'receiver_id' => $receiverId,
                'message' => $request->message,
            ]);
            
            $message->load('sender');
            
            broadcast(new NewMessage($message))->toOthers();
            
            return response()->json([
                'status' => 'Message sent!',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            Log::error('Chat message error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'An error occurred while sending your message',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }


    public function create(Request $request)
    {
        $userId = Auth::id();
        
        $followingIds = Follow::where('follower_id', $userId)
            ->pluck('following_id')
            ->toArray();
        
        $users = User::whereIn('id', $followingIds)->get();
        
        return view('pages.chat.create', compact('users'));
    }

    public function storeChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
        
        $userId = Auth::id();
        $otherUserId = $request->user_id;
        
        $chat = Chat::where(function($query) use ($userId, $otherUserId) {
                $query->where('user_one_id', $userId)
                      ->where('user_two_id', $otherUserId);
            })
            ->orWhere(function($query) use ($userId, $otherUserId) {
                $query->where('user_one_id', $otherUserId)
                      ->where('user_two_id', $userId);
            })
            ->first();
        
        if (!$chat) {
            $chat = Chat::create([
                'user_one_id' => $userId,
                'user_two_id' => $otherUserId,
            ]);
        }
        
        return redirect()->route('chat.show', $chat);
    }
}