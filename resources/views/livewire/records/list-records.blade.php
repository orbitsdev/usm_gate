<div>


    <x-live-wire-layout>
        <div class="flex items-center">
            <a href="{{ route('days') }}" class="inline-block mt-4 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-gray-700 border border-transparent rounded-md focus:outline-none focus:shadow-outline-gray active:bg-gray-800 mb-3">
                Go Back
            </a>
            <p class="text-4xl ml-4 text-gray-700">
                @if($day)
                {{$day->created_at->format('F j, Y - l')}}
                @endif
            </p>
        </div>
        
        {{-- {{ $this->deleteAction }} --}}
        {{ $this->table }}
    </x-live-wire-layout>
</div>
