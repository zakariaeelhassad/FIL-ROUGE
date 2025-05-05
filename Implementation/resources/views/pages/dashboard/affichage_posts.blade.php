@extends('layouts.dashboard', ['title' => 'posts'])

@section('content')
<section class="mb-8">
  <div class="flex justify-between items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold">Content Moderation</h2>
      <p class="text-gray-400 mt-1">Manage posts, comments, and reactions</p>
    </div>
    <div class="flex space-x-3">
      <div>
        <form action="{{ route('posts.admin') }}" method="GET" class="flex">
            <input type="text" name="search" placeholder="Search posts..." 
                   class="bg-gray-700 text-white px-4 py-2 rounded-l-lg focus:outline-none"
                   value="{{ request('search') }}">
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-r-lg">
                <i class="fas fa-search"></i>
            </button>
        </form>
      </div>
      <div class="relative">
        <button id="filterButtonPost" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
          <i class="fas fa-filter mr-2"></i>
          Filter
        </button>
        <div id="filterDropdownPost" class="absolute right-0 mt-2 w-56 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hidden z-10">
          <div class="p-4">
            <h3 class="text-white font-medium mb-3">Filter Posts</h3>
            <form action="{{ route('posts.admin') }}" method="GET">
              <div class="mb-3">
                <label class="block text-gray-400 text-sm mb-2">Media Type</label>
                <div class="space-y-2">
                  <div class="flex items-center">
                    <input type="radio" id="all_media" name="media_type" value="" class="mr-2" {{ request('media_type') == '' ? 'checked' : '' }}>
                    <label for="all_media" class="text-gray-300 text-sm">All</label>
                  </div>
                  <div class="flex items-center">
                    <input type="radio" id="image" name="media_type" value="image" class="mr-2" {{ request('media_type') == 'image' ? 'checked' : '' }}>
                    <label for="image" class="text-gray-300 text-sm">Photos Only</label>
                  </div>
                  <div class="flex items-center">
                    <input type="radio" id="video" name="media_type" value="video" class="mr-2" {{ request('media_type') == 'video' ? 'checked' : '' }}>
                    <label for="video" class="text-gray-300 text-sm">Videos Only</label>
                  </div>
                  <div class="flex items-center">
                    <input type="radio" id="with_media" name="media_type" value="any" class="mr-2" {{ request('media_type') == 'any' ? 'checked' : '' }}>
                    <label for="with_media" class="text-gray-300 text-sm">Any Media</label>
                  </div>
                  <div class="flex items-center">
                    <input type="radio" id="no_media" name="media_type" value="none" class="mr-2" {{ request('media_type') == 'none' ? 'checked' : '' }}>
                    <label for="no_media" class="text-gray-300 text-sm">No Media</label>
                  </div>
                </div>
              </div>
              <div class="mb-3">
                <div class="flex items-center">
                    <input type="checkbox" id="with_reports" name="with_reports" value="1" class="mr-2" {{ request('with_reports') == '1' ? 'checked' : '' }}>
                    <label for="with_reports" class="text-gray-300 text-sm">With Reports Only</label>
                </div>
            </div>                            

            <div class="mb-3">
                <label class="block text-gray-400 text-sm mb-2">Sort by Reports</label>
                <select name="sort_by_reports" class="w-full px-2 py-1 bg-gray-700 text-white rounded text-sm">
                    <option value="">No Sorting</option>
                    <option value="desc" {{ request('sort_by_reports') == 'desc' ? 'selected' : '' }}>Most Reported</option>
                    <option value="asc" {{ request('sort_by_reports') == 'asc' ? 'selected' : '' }}>Least Reported</option>
                </select>
            </div>

              <div class="flex justify-end">
                <button type="submit" class="bg-brand-100 hover:bg-brand-200 text-white px-3 py-1 rounded text-sm">Apply Filters</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      @foreach ($posts as $post)
        <div class="bg-gray-800 border border-gray-700 rounded-xl p-5">
          <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <img
                    src="{{ asset('storage/' . ($post->profile_image ?? '../../../images/la-personne.png')) }}" 
                    alt="Profile"
                    class="rounded-full w-12 h-12 object-cover border-2 border-brand-100"
                />
              <div class="ml-3">
                <div class="text-sm font-medium">{{ $post->user->full_name }}</div>
                <div class="text-xs text-gray-400">{{ $post->created_at->diffForHumans() }}</div>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              @if($post->is_reported)
                <span class="px-2 py-1 text-xs rounded-full bg-red-900 bg-opacity-30 text-red-400">Reported</span>
              @endif
              <button class="text-gray-400 hover:text-white">
                <i class="fas fa-ellipsis-v"></i>
              </button>
            </div>
          </div>
  
          <div class="mb-4">
            <p class="text-sm">{{ $post->content }}</p>
          </div>
  
            @if($post->media->isNotEmpty())
                <div class="border-t border-b border-gray-100 space-y-4 m-4">
                    @foreach($post->media as $media)
                        @if($media->type === 'image')
                            <img 
                                src="{{ asset('storage/' . $media->path) }}" 
                                alt="Post image" 
                                class="w-full object-cover rounded-xl"
                            >
                        @elseif($media->type === 'video')
                            <video 
                                controls 
                                class="w-full rounded-xl"
                            >
                                <source src="{{ asset('storage/' . $media->path) }}" type="video/mp4">
                                Ton navigateur ne supporte pas la lecture vidéo.
                            </video>
                        @endif
                    @endforeach
                </div>
            @endif
  
          <div class="flex items-center justify-between text-sm text-gray-400">
            <div class="flex space-x-4">
              <div class="flex items-center">
                <i class="fas fa-heart text-red-400 mr-1"></i>
                {{ $post->reactions->count() }}
              </div>
              <div class="flex items-center">
                <i class="fas fa-comment text-blue-400 mr-1"></i>
                {{ $post->comments->count() }}
              </div>
              <div class="flex items-center">
                <i class="fas fa-comment text-blue-400 mr-1"></i>
                {{ $post->reports_count }}
              </div>
            </div>
  
            <div class="flex space-x-2">
              <form action="{{ route('delete.post', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded-md">
                     Delete
                  </button>
              </form> 
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function() {
      const filterButton = document.getElementById('filterButtonPost');
      const filterDropdown = document.getElementById('filterDropdownPost');
      
      filterButton.addEventListener('click', function() {
          filterDropdown.classList.toggle('hidden');
      });
      
      document.addEventListener('click', function(event) {
          if (!filterButton.contains(event.target) && !filterDropdown.contains(event.target)) {
              filterDropdown.classList.add('hidden');
          }
      });
  });
</script>
@endsection

