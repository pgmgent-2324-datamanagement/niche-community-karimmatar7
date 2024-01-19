<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="firstname" :value="__('First Name')" />
            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
   <!-- Email Address -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
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


        <div class="mt-4">
    <label class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"  for="date_of_birth">{{ __('Date of Birth') }}</label>
    <input class="block mt-1 w-full" type="date" name="date_of_birth" id="date_of_birth" :value="old('date_of_birth')" required autofocus autocomplete="date_of_birth">
    <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
</div>


        <div class="mt-4">
    <x-input-label for="gender" :value="__('Gender')" />
    <select id="gender" name="gender" class="block w-full mt-1">
        <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
        <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
    </select>
    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
</div>


<div class="mt-4">
            <label for="profile_image" class="block text-sm font-medium text-gray-700">Profile Image</label>
            <input type="file" name="profile_image" id="profile_image" class="mt-1 p-2 w-full border rounded-md">
            <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
