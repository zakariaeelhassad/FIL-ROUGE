<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Users Card -->
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-blue-500 transition-colors">
      <div class="flex justify-between items-start">
        <div>
          <div class="text-gray-400 text-sm font-medium">Total Users</div>
          <div class="text-2xl font-bold mt-1">{{ $users->count() }}</div>
        </div>
        <div class="bg-gray-700 p-3 rounded-lg">
          <i class="fas fa-users text-blue-400"></i>
        </div>
      </div>
    </div>
    
    <!-- Total Posts Card -->
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-blue-500 transition-colors">
      <div class="flex justify-between items-start">
        <div>
          <div class="text-gray-400 text-sm font-medium">Total Posts</div>
          <div class="text-2xl font-bold mt-1">{{ $posts->count() }}</div> 
        </div>
        <div class="bg-gray-700 p-3 rounded-lg">
          <i class="fas fa-file-alt text-blue-400"></i>
        </div>
      </div>
    </div>
    
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-blue-500 transition-colors">
      <div class="flex justify-between items-start">
        <div>
          <div class="text-gray-400 text-sm font-medium">Messages</div>
          <div class="text-2xl font-bold mt-1">{{ $totalChats }}</div> 
        </div>
        <div class="bg-gray-700 p-3 rounded-lg">
          <i class="fas fa-comment text-purple-400"></i>
        </div>
      </div>
    </div>
    
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 hover:border-blue-500 transition-colors">
      <div class="flex justify-between items-start">
        <div>
          <div class="text-gray-400 text-sm font-medium">Reports</div>
          <div class="text-2xl font-bold mt-1">{{ $totalReports }}</div> 
        </div>
        <div class="bg-gray-700 p-3 rounded-lg">
          <i class="fas fa-exclamation-circle text-red-400"></i>
        </div>
      </div>
    </div>
</div>
