<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        @if($user->role == 'pasien')
        <div>
            <x-input-label for="name" :value="__('No RM')" />
            <x-text-input id="name" name="no_rm" type="text" class="mt-1 block w-full" :value="old('No RM', $user->no_rm)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('no_rm')" />
        </div>
        @endif
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="nama" type="text" class="mt-1 block w-full" :value="old('name', $user->nama)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
        </div>

        <div>
            <x-input-label for="no_ktp" :value="__('No KTP')" />
            <x-text-input id="no_ktp" name="no_ktp" type="text" class="mt-1 block w-full" :value="old('no_ktp', $user->no_ktp)" required autofocus autocomplete="no_ktp" />
            <x-input-error class="mt-2" :messages="$errors->get('no_ktp')" />
        </div>
        <div>
            <x-input-label for="no_hp" :value="__('No HP')" />
            <x-text-input id="no_hp" name="no_hp" type="number" class="mt-1 block w-full" :value="old('no_hp', $user->no_hp)" required autofocus autocomplete="no_hp" />
            <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

         <div>
            <x-input-label for="poli" :value="__('Poli')" />
            <x-text-input id="poli" name="poli" type="text" class="mt-1 block w-full" :value="old('poli', $user->poli)" required autofocus autocomplete="poli" />
            <x-input-error class="mt-2" :messages="$errors->get('poli')" />
        </div>
         <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" :value="old('alamat', $user->alamat)" required autofocus autocomplete="alamat" />
            <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
