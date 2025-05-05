@extends('layouts.dashboard', ['title' => 'users'])

@section('content')
<section class="mb-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">User Management</h2>
            <p class="text-gray-400 mt-1">Manage platform users and permissions</p>
        </div>
        <div class="flex space-x-3">
            <div class="relative">
                <button id="filterButtonUser" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                <div id="filterDropdownUser" class="absolute right-0 mt-2 w-72 bg-gray-800 border border-gray-700 rounded-lg shadow-lg hidden z-10">
                    <div class="p-4">
                        <h3 class="text-white font-medium mb-3">Filter Users</h3>
                        <form action="{{ route('users.admin') }}" method="GET">
                            <div class="mb-3">
                                <label class="block text-gray-400 text-sm mb-2">Role</label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" id="all_roles" name="role" value="" class="mr-2" {{ request('role') == '' ? 'checked' : '' }}>
                                        <label for="all_roles" class="text-gray-300 text-sm">All</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="joueur" name="role" value="joueur" class="mr-2" {{ request('role') == 'joueur' ? 'checked' : '' }}>
                                        <label for="joueur" class="text-gray-300 text-sm">Joueur</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" id="club_admin" name="role" value="club_admin" class="mr-2" {{ request('role') == 'club_admin' ? 'checked' : '' }}>
                                        <label for="club_admin" class="text-gray-300 text-sm">Club</label>
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
  
    <!-- Table -->
    <div>
        <div class="bg-gray-800 border border-gray-700 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Posts</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">report</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach ($users as $user)
                        <tr class="hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . ($user->profile_image ?? '../../../images/la-personne.png')) }}" 
                                        alt="Profile" class="rounded-full w-12 h-12 object-cover border-2 border-brand-100" />
                                    <div class="ml-4">
                                        <div class="text-sm font-medium">{{ $user->full_name }}</div>
                                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm">{{ $user->role }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $user->posts->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $user->reportedReports->count() }} 
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{ $user->created_at }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <form action="{{ route('delete.user', $user->id) }} " method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>                                    
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </section>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButton = document.getElementById('filterButtonUser');
        const filterDropdown = document.getElementById('filterDropdownUser');
  
        filterButton.addEventListener('click', function(event) {
            event.stopPropagation();
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

  