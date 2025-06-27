<x-app-layout>
    <div class="min-h-[70vh] flex justify-center items-center">
        <form action="{{ route('password.email') }}" method="post" class="w-full max-w-md p-8 my-8 bg-gray-100 rounded-lg shadow-card">
            @csrf
            <h2 class="text-2xl font-semibold text-neutral-800 text-center mb-6">
                Reset Your Password
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email Address</label>
                <x-input
                    id="email"
                    class="block w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-300 focus:ring-opacity-50"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    placeholder="Enter your email address"
                />
            </div>

            <button
                class="w-full py-3 px-4 bg-primary-500 hover:bg-primary-600 active:bg-primary-700 text-white font-medium rounded-md transition-colors duration-200 shadow-sm"
            >
                Send Password Reset Link
            </button>

            <p class="text-center text-neutral-600 mt-6">
                Remember your password?
                <a
                    href="{{ route('login') }}"
                    class="text-accent-600 hover:text-accent-700 font-medium"
                >
                    Log in
                </a>
            </p>
        </form>
    </div>
</x-app-layout>
