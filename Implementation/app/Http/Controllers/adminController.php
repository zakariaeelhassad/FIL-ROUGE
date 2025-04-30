<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\Post;
use App\Models\Report;
use App\Models\User;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\Http\Request;

class adminController extends Controller
{
    protected UserService $userService;
    protected PostService $postService;

    public function __construct(UserService $userService , PostService $postService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
    }

    public function dashboard()
    {
        $users = User::where('id', '!=', auth()->id())->paginate(5);
        $posts = Post::paginate(2);
        $chats = Chat::with('messages')  
        ->orderByDesc(function ($query) {
            $query->select('created_at') 
                  ->from('messages')
                  ->whereColumn('messages.chat_id', 'chats.id')
                  ->latest()  
                  ->limit(1);  
        })
        ->paginate(5);

        $reports = Report::with('reporter')  
                     ->latest()
                     ->paginate(5);

        $totalChats = Message::count();
        $totalReports = Report::count();
        


        return view('pages.dashboard', compact('users' , 'posts' , 'chats' , 'reports' , 'totalChats' , 'totalReports'));
    }

    public function users()
    {
        $users = $this->userService->paginate(); 
        return view('components.dashboard.affichage_users', compact('users'));
    }

    public function posts()
    {
        $posts = $this->postService->paginate(); 
        return view('components.dashboard.affichage_posts', compact('posts'));
    }

    public function conversations()
    {
        $chats = Chat::paginate(10); 
        return view('components.dashboard.affichage_messages', compact('chats'));
    }

    public function reports()
    {
        $reports = Report::with('reporter')->latest()->paginate(10);
        return view('components.dashboard.affichage_reports', compact('reports'));
    }


}
