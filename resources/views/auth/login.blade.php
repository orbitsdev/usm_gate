<x-guest-layout>
    
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
    
        <x-validation-errors class="mb-4" />
    
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
    
            <div>
                <x-label  class="text-gray-600 mb-0.5" for="email" value="{{ __('Email') }}"> Email </x-label>
                <input id="email" class="border border-[#5f5e5e28] w-full rounded focus:border-[#FDDC01] focus:ring-0" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
    
            <div>

                <x-label  class="text-gray-600 mb-0.5" for="password" value="{{ __('password') }}"> Password </x-label>
                <input id="password" class="border border-[#5f5e5e28] w-full rounded focus:border-[#FDDC01] focus:ring-0" type="password" name="password" required autocomplete="current-password" />
            </div>
            
            {{-- <div class="">   
                <input type="text" name="" id="" class="border border-[#5f5e5e28] w-full rounded focus:border-[#FDDC01] focus:ring-0">
            </div> --}}
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

