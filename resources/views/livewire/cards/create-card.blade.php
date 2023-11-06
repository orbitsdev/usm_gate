<div>
    <x-live-wire-layout>
    <form wire:submit="create">
        {{ $this->form }}

        {{-- <button type="submit">
            Submit
        </button> --}}

        <div class="mt-4 flex items-center ">

            <div class="mr-4">
                {{ $this->back }}

            </div>

            <div>
                {{ $this->submitAction }}

            </div>

        </div>

      
    </form>
    <x-filament-actions::modals />
</x-live-wire-layout>
</div>
