@extends('layouts.app', ['title' => 'Home'])

@section('content')
<div class="max-w-6xl mx-auto px-4 pt-6 pb-12">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Left Sidebar -->
        <div class="md:w-1/4 md:sticky md:top-20 self-start">
            @include('components.home.mini_profil')
        </div>

        <div class="md:w-2/3">
            <div class="space-y-6">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white rounded-2xl p-5 shadow-soft hover-lift border border-gray-100">
                        <div class="flex items-center space-x-4">
                            @php
                                $authUser = Auth::user();
                            @endphp
                            <a href="{{ route('profil.show', ['id' => $authUser->id]) }}">
                                <img 
                                    src="{{ asset('storage/' . ($authUser->profile_image ?? '../../../images/la-personne.png')) }}" 
                                    class="w-12 h-12 rounded-full object-cover border-2 border-brand-100"
                                    alt="Profile"
                                >
                            </a>
                            <input type="text" name="content" placeholder="What's on your mind?" class="flex-grow bg-gray-50 rounded-full px-5 py-3 focus:outline-none focus:ring-2 focus:ring-brand-300 transition text-gray-700" required>
                            <button type="submit" class="bg-brand-500 text-white rounded-full px-6 py-3 hover:bg-brand-600 transition font-medium shadow-sm">
                                Post
                            </button>
                        </div>
                
                        @if($errors->has('media'))
                            <div class="mt-2 text-red-500 text-sm">
                                {{ $errors->first('media') }}
                            </div>
                        @endif
                
                        <!-- Post Options -->
                        <div class="flex mt-4 pt-3 border-t border-gray-100">
                            <!-- Photo Input -->
                            <label class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 rounded-xl px-4 py-2 transition flex-1 cursor-pointer">
                                <i class="fas fa-image text-brand-500"></i>
                                <span>Photo</span>
                                <input type="file" name="media[]" class="hidden" accept="image/*" multiple>
                            </label>
                
                            <!-- Video Button -->
                            <button type="button" class="flex items-center justify-center space-x-2 text-gray-600 hover:bg-gray-50 rounded-xl px-4 py-2 transition flex-1" onclick="document.getElementById('videoInput').click()">
                                <i class="fas fa-video text-green-500"></i>
                                <span>Video</span>
                            </button>
                            <!-- Hidden Video Input -->
                            <input type="file" name="media[]" id="videoInput" class="hidden" accept="video/*" multiple>
                        </div>
                    </div>
                </form>
                
                <!-- Posts Feed -->
                @foreach ($posts as $post)
                    @include('components.home.post-card', ['post' => $post])
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/home.js') }}"></script>
@endpush