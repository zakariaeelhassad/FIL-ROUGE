<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Comment;
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

    private function getDashboardData()
    {
        $users = User::where('id', '!=', auth()->id())->get(); 
        $posts = Post::all();
        $chats = Chat::with('messages')  
            ->orderByDesc(function ($query) {
                $query->select('created_at') 
                    ->from('messages')
                    ->whereColumn('messages.chat_id', 'chats.id')
                    ->latest()
                    ->limit(1);
            })
            ->get();
        $reports = Report::with('reporter')  
            ->latest()
            ->get(); 

        $totalChats = Message::count();
        $totalReports = Report::count();

        return compact('users' , 'posts', 'chats', 'reports', 'totalChats', 'totalReports');
    }

    private function getDashboardDat()
    {
        $users = User::where('id', '!=', auth()->id())->latest()->take(2)->get(); 
        $posts = Post::latest()->take(2)->get();  
        $comments = Comment::with('post', 'user')->latest()->take(2)->get(); 
        $reports = Report::with('reporter')->latest()->take(2)->get();  

        $chats = Chat::with('messages')  
            ->orderByDesc(function ($query) {
                $query->select('created_at') 
                    ->from('messages')
                    ->whereColumn('messages.chat_id', 'chats.id')
                    ->latest()
                    ->limit(1);
            })
            ->get();

        $totalChats = Message::count();
        $totalReports = Report::count();

        return compact('users', 'posts', 'comments', 'reports', 'chats', 'totalChats', 'totalReports');
    }


    public function dashboard()
    {
        return view('pages.dashboard.home', $this->getDashboardDat());
    }


    public function users(Request $request)
    {
        $data = $this->getDashboardData();

        $query = User::query()->where('role', '!=', 'admin');

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('full_name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        if ($request->has('role') && in_array($request->role, ['joueur', 'club_admin'])) {
            $query->where('role', $request->role);
        }

        if ($request->has('with_reports') && $request->with_reports == '1') {
            $query->has('reportedReports');
        }

        $query->withCount('reportedReports');

        if ($request->has('sort_by_reports') && $request->sort_by_reports === 'desc') {
            $query->orderByDesc('reported_reports_count');
        } elseif ($request->has('sort_by_reports') && $request->sort_by_reports === 'asc') {
            $query->orderBy('reported_reports_count');
        }

        $data['users'] = $query->get(); 

        return view('pages.dashboard.affichage_users', $data);
    }

    public function posts(Request $request)
    {
        $data = $this->getDashboardData();

        $query = Post::with(['user', 'media', 'reactions', 'comments', 'reports']);

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('content', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('full_name', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }

        if ($request->has('media_type')) {
            switch ($request->media_type) {
                case 'image':
                    $query->whereHas('media', function ($q) {
                        $q->where('type', 'image');
                    });
                    break;
                case 'video':
                    $query->whereHas('media', function ($q) {
                        $q->where('type', 'video');
                    });
                    break;
                case 'any':
                    $query->whereHas('media');
                    break;
                case 'none':
                    $query->whereDoesntHave('media');
                    break;
            }
        }

        if ($request->has('with_reports') && $request->with_reports == '1') {
            $query->has('reports'); 
        }

        $query->withCount('reports');

        if ($request->has('sort_by_reports') && $request->sort_by_reports === 'desc') {
            $query->orderByDesc('reports_count');
        } elseif ($request->has('sort_by_reports') && $request->sort_by_reports === 'asc') {
            $query->orderBy('reports_count');
        }

        $data['posts'] = $query->get();

        return view('pages.dashboard.affichage_posts', $data);
    }  

    public function comments(Request $request)
    {
        $data = $this->getDashboardData(); 
        
        $query = Comment::with(['post', 'user', 'replies.user']);
        
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('content', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhereHas('user', function($userQuery) use ($searchTerm) {
                      $userQuery->where('full_name', 'LIKE', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('post', function($postQuery) use ($searchTerm) {
                      $postQuery->where('content', 'LIKE', '%' . $searchTerm . '%');
                  });
            });
        }
    
        $data['comments'] = $query->latest()->get();
    
        return view('pages.dashboard.affichage_commenter', $data); 
    }
    

    public function reports(Request $request)
    {
        $data = $this->getDashboardData(); 
        
        $query = Report::with('reporter');
        
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('reason', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('reporter', function($reporterQuery) use ($searchTerm) {
                    $reporterQuery->where('full_name', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $data['reports'] = $query->latest()->get(); 

        return view('pages.dashboard.affichage_reports', $data);
    }
    

}