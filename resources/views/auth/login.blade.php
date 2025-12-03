<x-guest-layout>
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-2xl mb-4 animate-pulse">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Welcome Back!</h2>
        <p class="text-gray-600">Sign in to manage your inventory</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-700">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                    </svg>
                    Email Address
                </div>
            </label>
            <div class="relative">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full px-4 py-3 pl-11 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all shadow-sm"
                    placeholder="your@email.com">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-700">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Password
                </div>
            </label>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full px-4 py-3 pl-11 rounded-xl border-2 border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-all shadow-sm"
                    placeholder="Enter your password">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-2 cursor-pointer" name="remember">
                <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-700 font-medium hover:underline transition-all" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="group relative w-full inline-flex items-center justify-center gap-3 px-6 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 hover:shadow-xl hover:shadow-blue-300 transition-all transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span class="text-lg">Sign In</span>
                <div class="absolute inset-0 rounded-xl bg-white opacity-0 group-hover:opacity-10 transition-opacity"></div>
            </button>
        </div>
    </form>

    <!-- Additional Info -->
    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
        <p class="text-sm text-gray-500">
            Secure access to Stock Opname System
        </p>
        <div class="flex items-center justify-center gap-2 mt-2">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-xs text-gray-500">Protected by Laravel Sanctum</span>
        </div>
    </div>
</x-guest-layout>
