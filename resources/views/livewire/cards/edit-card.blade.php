<div>
    <x-live-wire-layout>
    <form wire:submit="save">
        {{ $this->form }}
        {{-- <p class="p-6 mt-4 text-gray-600">
            "The system meticulously validates the 'Valid From' and 'Valid Until' dates, automatically updating the card status if it is determined to be expired. It only validate if the status is active."
        </p> --}}
        <div class="mt-6 flex items-center ">
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
