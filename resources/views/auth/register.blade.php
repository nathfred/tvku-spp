<title>TVKU | {{ $title }}</title>
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img class="h-20 fill-current text-gray-500" src="{{ asset('img/tvku_logo_ori.png') }}"</>
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!---- Gender -->
            <div class="mt-4">
                <x-label for="gender" :value="__('Jenis Kelamin')" />

                <div class="row">
                    <div class="col col-1 mt-1">
                        <x-input id="gender" type="radio" name="gender" value="male" required />
                    </div>
                    <div class="col col-4 mt-1">
                        <x-label for="gender">Laki-laki</x-label> 
                    </div>
                </div>
                <div class="row">
                    <div class="col col-1 mt-1">
                        <x-input id="gender" type="radio" name="gender" value="female" required />
                    </div>
                    <div class="col col-4 mt-1">
                        <x-label for="gender">Perempuan</x-label> 
                    </div>
                </div>
            </div>

            <!-- Kode -->
            <div class="mt-4">
                <x-label for="code" :value="__('Kode')" />

                <x-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah punya akun?') }}
                </a>

                <x-button class="ml-4 btn btn-primary">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
