<x-app-layout>
    <div class="min-h-[70vh] flex justify-center items-center">
        <div class="w-full max-w-md p-8 my-8 bg-gray-100 rounded-lg shadow-card">
            <h2 class="text-2xl font-semibold text-neutral-800 text-center mb-6">
                Set Your New Password
            </h2>

            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-neutral-700 mb-1">Email Address</label>
                    <x-input
                        id="email"
                        class="block w-full rounded-md border-dashed border-gray-500 bg-gray-200 text-neutral-600 focus:ring-0 cursor-not-allowed"
                        type="email"
                        name="email"
                        :value="old('email', $request->email)"
                        required
                        readonly
                    />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-neutral-700 mb-1">Password</label>
                    <x-input
                        id="password"
                        class="block w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-300 focus:ring-opacity-50"
                        type="password"
                        name="password"
                        required
                    />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-neutral-700 mb-1">Confirm Password</label>
                    <x-input
                        id="password_confirmation"
                        class="block w-full rounded-md border-gray-500 focus:border-primary-500 focus:ring focus:ring-primary-300 focus:ring-opacity-50"
                        type="password"
                        name="password_confirmation"
                        required
                    />
                </div>

                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-primary-500 hover:bg-primary-600 active:bg-primary-700 text-white font-medium rounded-md transition-colors duration-200 shadow-sm"
                >
                    Reset Password
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
