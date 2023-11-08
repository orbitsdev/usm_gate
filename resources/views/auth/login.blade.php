<x-guest-layout>
    
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
    
        <x-validation-errors class="mb-4" />
    
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
    
            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
    
            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block w-full" type="password" name="password" required autocomplete="current-password" />
            </div>
    
            <div class="flex items-center">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox 
                        id="remember_me" 
                        name="remember" 
                        class="mr-2 checked:text-yellow-500 focus:text-yellow-500 focus:ring-yellow-500 focus:border-yellow-500 border-yellow-500" 
                    />
                    <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>
            
            
            <div class="flex items-center justify-end">
                <button type="submit" class="bg-black py-2 px-4 rounded-lg text-white w-full">Login</button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

