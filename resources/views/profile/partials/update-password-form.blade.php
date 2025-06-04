<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Current Password --}}
        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Current Password') }}
            </label>
            <input id="current_password" name="current_password" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                autocomplete="current-password">
            @if ($errors->updatePassword->has('current_password'))
                <p class="text-sm text-red-600 mt-2">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        {{-- New Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('New Password') }}
            </label>
            <input id="password" name="password" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                autocomplete="new-password">
            @if ($errors->updatePassword->has('password'))
                <p class="text-sm text-red-600 mt-2">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                {{ __('Confirm Password') }}
            </label>
            <input id="password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                autocomplete="new-password">
            @if ($errors->updatePassword->has('password_confirmation'))
                <p class="text-sm text-red-600 mt-2">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                {{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
