<x-layouts.auth>
    <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ __('Register') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('Enter your details below to create your account') }}
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <!-- Full Name Input -->
                <div class="mb-4">
                    <x-forms.input label="Full Name" name="name" type="text" placeholder="{{ __('Full Name') }}"
                        value="{{ old('name') }}" />
                </div>

                <!-- Email Input -->
                <div class="mb-4">
                    <x-forms.input label="Email" name="email" type="email" placeholder="your@email.com"
                        value="{{ old('email') }}" />
                </div>

                <!-- Birthdate Input -->
                <div class="mb-4">
                    <x-forms.date-picker label="Birthdate" name="birthdate" value="{{ old('birthdate') }}" />
                </div>

                <!-- Gender Input -->
                <div class="mb-4">
                    <label for="gender"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Gender') }}</label>
                    <select name="gender" id="gender"
                        class="mt-1 block w-full bg-gray-100 rounded-md py-2.5 px-3 border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="" disabled {{ old('gender') ? '' : 'selected' }}>{{ __('Select Gender') }}
                        </option>
                        <option value="Pria" {{ old('gender') == 'Pria' ? 'selected' : '' }}>{{ __('Male') }}
                        </option>
                        <option value="Wanita" {{ old('gender') == 'Wanita' ? 'selected' : '' }}>{{ __('Female') }}
                        </option>
                    </select>
                    @error('gender')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                    <x-forms.input label="Password" name="password" type="password" placeholder="••••••••" />
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-4">
                    <x-forms.input label="Confirm Password" name="password_confirmation" type="password"
                        placeholder="••••••••" />
                </div>

                <!-- Register Button -->
                <x-button type="primary" class="w-full">{{ __('Create Account') }}</x-button>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-blue-600 dark:text-blue-400 hover:underline font-medium">{{ __('Sign in') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-layouts.auth>
