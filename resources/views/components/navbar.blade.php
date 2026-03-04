<nav class="bg-emerald-900 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <div class="flex items-center gap-3">
            <!-- Logo Placeholder -->
            <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight">Kejaksaan Negeri Kabupaten Tegal</h1>
                <p class="text-xs text-emerald-200">Sistem Informasi Pelayanan Magang</p>
            </div>
        </div>
        @if(request()->routeIs('home'))
            @auth
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium hover:text-emerald-200 transition">Dashboard Admin &rarr;</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-emerald-200 transition">Login Admin</a>
            @endauth
        @endif
      </div>
    </div>
</nav>
