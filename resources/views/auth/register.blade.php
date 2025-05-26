<x-guest-layout>
    @if (session('status'))
    <div class="{{ session('status') === 'success' ? 'bg-green-500' : 'bg-red-500' }} text-white p-4 rounded-md mb-4">
        {{ session('message') }}
    </div>
    @endif

    <h2 class="text-center text-2xl font-semibold mb-3">{{ __('Register') }}</h2>
    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <!-- Name -->
       <div class="flex flex-col gap-4">
         <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="name" :value="__('Email')" />
            <x-text-input id="name" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="name" :value="__('No KTP')" />
            <x-text-input id="name" class="block mt-1 w-full" type="number" name="no_ktp" :value="old('no_ktp')" required autofocus autocomplete="name" maxlength="16" />
            <x-input-error :messages="$errors->get('no_ktp')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="name" :value="__('No HP')" />
            <x-text-input id="name" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')" required autofocus autocomplete="name" maxlength="12"/>
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="name" :value="__('Alamat')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="alamat" :value="old('alamat')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
        </div>
       </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login.index') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
