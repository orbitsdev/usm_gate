<div>
    <x-live-wire-layout>
        {{ $this->form }}
        {{-- <button type="submit" wire:click="create" class="mt-12">
            Update
        </button> --}}
        <div class="mt-12">
            {{$this->updateAccountAction}}
        </div>
        {{-- <form wire:submit="create">
            
        </form> --}}
        {{-- <div class="container mx-auto p-8">
            <div class="flex items-center">
                <div class="w-64 h-64 bg-gray-300 rounded-full overflow-hidden">
                    <img src="{{asset('images/sample.jpg')}}" alt="Profile Image" class="w-full h-full object-cover">
                </div>
                <div class="ml-8">
                    <h2 class="text-2xl font-bold capitalize">{{Auth::user()->name ?? ''}}</h2>
                    <div class="flex items-center mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" d="M16.5 12a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 10-2.636 6.364M16.5 12V8.25" />
                        </svg>
                        <p class="text-gray-600">Email: {{Auth::user()->email ?? ''}}</p>
                    </div>
                    <div class="mt-4">
                        <button wire:click="toggleChangePassword" class="py-2 px-4 rounded-full transition @if($isChangePassword) bg-gray-100 text-gray-400 @else bg-blue-500 text-white @endif">Change Password</button>
                    </div>

                    @if($isChangePassword)
                        <div class="transition">
                            <div class="mb-4">
                                <label for="name" class="block">Name</label>
                                <x-input type="text" id="name" name="name" value="{{Auth::user()->name ?? ''}}" class="mt-1 p-2 border border-gray-300 rounded-md w-full"/>
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="block">New Password</label>
                                <x-input type="password" id="new_password" name="new_password" />
                            </div>
                            <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded-full">Update Profile</button>
                        </div>
                    @endif
                </div>
            </div>
        </div> --}}
        <x-filament-actions::modals />
    </x-live-wire-layout>
</div>
