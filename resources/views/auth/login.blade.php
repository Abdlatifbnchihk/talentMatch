<x-guest-layout>
    <h2 class="text-2xl font-bold text-slate-800 mb-1">Welcome back 👋</h2>
    <p class="text-slate-400 text-sm mb-8">Sign in to your account</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                    placeholder="you@example.com">
            </div>
            @error('email') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <input id="password" type="password" name="password" required
                    class="block w-full pl-10 pr-10 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                    placeholder="••••••••">
                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <svg id="eye-icon" class="w-5 h-5 text-slate-400 hover:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>
            @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Remember me + Forgot password --}}
        <div class="flex items-center justify-between mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-slate-600">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-700 transition-all duration-200">Forgot password?</a>
            @endif
        </div>

        {{-- Sign in button --}}
        <button type="submit" class="w-full flex items-center justify-center gap-2 bg-indigo-600 text-white py-2.5 px-4 rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
            Sign in
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
            </svg>
        </button>
    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-4 my-6">
        <div class="flex-1 border-t border-slate-200"></div>
        <span class="text-xs text-slate-400">or</span>
        <div class="flex-1 border-t border-slate-200"></div>
    </div>

    {{-- Register link --}}
    <p class="text-center text-sm text-slate-500">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-all duration-200">Register</a>
    </p>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</x-guest-layout>
