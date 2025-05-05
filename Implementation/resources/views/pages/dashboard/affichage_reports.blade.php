@extends('layouts.dashboard', ['title' => 'reports'])

@section('content')
<section class="mb-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
      <div class="mb-4 md:mb-0">
        <h2 class="text-2xl font-bold">Reports & Analytics</h2>
        <p class="text-gray-400">Platform performance and user reports</p>
      </div>
      <div>
                <form action="{{ route('reports') }}" method="GET" class="flex">
                    <input type="text" name="search" placeholder="Search reports..." 
                           class="bg-gray-700 text-white px-4 py-2 rounded-l-lg focus:outline-none"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-r-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
      
    </div>
    

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Content Reports</h3>
        </div>
        
        <div class="space-y-4">
          @foreach ($reports as $report)
          <div class="bg-red-900/20 border border-red-500/30 rounded-lg p-4">
            <div class="flex flex-col sm:flex-row justify-between items-start mb-3">
              <div class="flex items-start mb-2 sm:mb-0">
                <div class="h-10 mr-3">
                    <img
                        src="{{ asset('storage/' . ($report->profile_image ?? '../../../images/la-personne.png')) }}" 
                        alt="Profile"
                        class="rounded-full w-12 h-12 object-cover border-2 border-brand-100"
                    />
                </div>
                <div>
                  <div class="text-sm font-medium">
                    @if ($report->reported_type === 'post')
                        {{ $report->reporter->full_name ?? 'Utilisateur supprimé' }} report le post #{{$report->reported_id}} by {{ $report->reportedPost->user->full_name ?? 'posts supprimé' }} 
                    @elseif ($report->reported_type === 'comment')
                        {{ $report->reporter->full_name ?? 'Utilisateur supprimé' }} report le comment #{{$report->reported_id}} by {{ $report->reportedPost->user->full_name ?? 'Utilisateur supprimé' }} 
                    @elseif ($report->reported_type === 'user')
                        {{ $report->reporter->full_name ?? 'Utilisateur supprimé' }} report le users {{ $report->reportedPost->user->full_name ?? 'Utilisateur supprimé' }}  #{{$report->reported_id}} 
                    @else
                        Unknown Report Type
                    @endif
                </div>
                
                  <div class="text-xs text-gray-400 mt-1">Reported {{ $report->count_reports ?? 1 }} times for {{ ucfirst($report->reported_type) }}</div>
                  <div class="text-sm text-gray-300 mt-2">{{ $report->reason}}</div>
                </div>
              </div>
              <div class="text-xs text-red-400">{{ $report->created_at->diffForHumans() }}</div>
            </div>
            <div class="flex justify-end gap-2">
              <form action="{{ route('repost.delete', $report->id) }} " method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md">
                    Delete
                </button>
            </form>
            </div>
          </div>
          @endforeach

        </div>
      </div>

  </section>
  @endsection