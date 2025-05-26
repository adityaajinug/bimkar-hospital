<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
    <div class="{{ session('status') === 'success' ? 'bg-green-500' : 'bg-red-500' }} text-white p-4 rounded-md mb-4">
        {{ session('message') }}
    </div>
    @endif
    
    <h2 class="text-center text-2xl font-semibold mb-3">{{ __('Login') }}</h2>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Email')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register.index') }}">
                {{ __('Dont have an account?') }}
            </a>
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
