<x-guest-layout>
    <h2 class="text-2xl font-bold text-slate-800 mb-1">Create your account</h2>
    <p class="text-slate-400 text-sm mb-8">Start pre-screening candidates with AI</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Full name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                    placeholder="John Doe">
            </div>
            @error('name') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
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
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                    placeholder="••••••••">
            </div>
            {{-- Password strength indicator --}}
            <div class="flex gap-1 mt-2">
                <div id="str-1" class="h-1 flex-1 rounded-full bg-slate-200 transition-all duration-200"></div>
                <div id="str-2" class="h-1 flex-1 rounded-full bg-slate-200 transition-all duration-200"></div>
                <div id="str-3" class="h-1 flex-1 rounded-full bg-slate-200 transition-all duration-200"></div>
            </div>
            @error('password') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Confirm password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-lg text-sm text-slate-800 placeholder-slate-400 focus:border-indigo-400 focus:ring-indigo-400 transition-all duration-200"
                    placeholder="••••••••">
            </div>
        </div>

        {{-- Terms checkbox --}}
        <div class="mb-6">
            <label class="inline-flex items-center">
                <input type="checkbox" name="terms" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-slate-600">I agree to the Terms of Service</span>
            </label>
        </div>

        {{-- Create account button --}}
        <button type="submit" class="w-full flex items-center justify-center bg-indigo-600 text-white py-2.5 px-4 rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
            Create account
        </button>
    </form>

    {{-- Login link --}}
    <p class="text-center text-sm text-slate-500 mt-6">
        Already have an account?
        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium transition-all duration-200">Sign in</a>
    </p>

    <script>
        document.getElementById('password')?.addEventListener('input', function() {
            const val = this.value;
            let score = 0;
            if (val.length >= 6) score++;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val) && /[0-9]/.test(val)) score++;

            for (let i = 1; i <= 3; i++) {
                const el = document.getElementById('str-' + i);
                el.className = 'h-1 flex-1 rounded-full transition-all duration-200 ';
                if (i <= score) {
                    el.className += score === 1 ? 'bg-red-400' : (score === 2 ? 'bg-amber-400' : 'bg-green-400');
                } else {
                    el.className += 'bg-slate-200';
                }
            }
        });
    </script>
</x-guest-layout>
