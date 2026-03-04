<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login Admin - Magang Kejari</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-4">

  <div class="w-full max-w-md bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="bg-emerald-900 p-6 text-center">
      <div class="h-12 w-12 mx-auto rounded-xl bg-white/10 grid place-items-center font-extrabold text-white text-xl mb-3">KN</div>
      <h1 class="text-white font-bold text-xl">Login Admin</h1>
      <p class="text-emerald-100 text-sm">Silahkan masuk untuk mengelola data.</p>
    </div>

    <div class="p-6 sm:p-8">
      @if($errors->any())
        <div class="mb-4 bg-rose-50 border border-rose-200 text-rose-600 px-4 py-3 rounded-xl text-sm">
            {{ $errors->first() }}
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                 class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition" />
        </div>

        <div>
          <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password</label>
          <input type="password" id="password" name="password" required
                 class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition" />
        </div>

        <div class="pt-2">
          <button type="submit" class="w-full bg-emerald-700 text-white font-bold py-2.5 rounded-xl hover:bg-emerald-800 transition shadow-sm hover:shadow-md">
            Masuk
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>