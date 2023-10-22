<div class="relative bg-contain bg-center font-sans flex items-center justify-center h-screen p-20" style="background-image: url('{{ asset('images/usmbg.png') }}');">

    <div class="absolute inset-0 bg-gradient-to-b from-[#13140f77] to-[#1a1a09]"></div>



    <div wire:poll.1s.visible class="relative z-10">
        <div class="p-8 rounded max-w-7xl w-full h-full text-center overflow-hidden">
            @if ($transaction)
                @if ($transaction->card)
                    @if ($transaction->card->account)
                        @if ($transaction->card->account->image)
                            <img src="{{ Storage::disk('public')->url($transaction->card->account->image) }}"
                                alt="Attendee Image" class="rounded-lg mx-auto mb-6 h-[60dvh] w-[60dvh] object-cover border-4 border-white">
                        @else
                            <img src="{{ asset('images/sample.jpg') }}" alt="Attendee Image"
                                class="rounded-full mx-auto mb-6 h-[55dvh] w-[55dvh] object-cover">
                        @endif
                        <h2 class="text-6xl font-bold mb-2 mt-8 text-white">
                            {{ $transaction->card->account->last_name ?? '' }},
                            {{ $transaction->card->account->first_name ?? '' }}
                        </h2>
                        <h2 class="text-3xl font-bold mb-2 mt-8 text-white">
                            @if ($transaction->scanned_type == 'entry')
                            Is Entering
                            @elseif($transaction->scanned_type == 'exit')
                             Is Exiting
                            @else
                            Cannot Define
                            @endif
                        </h2>
                        <p class="text-gray-600 text-lg mb-4">
                            {{-- Role or additional information --}}
                        </p>
                        <p class="text-4xl mt-4">
                            {{-- Display additional information --}}
                        </p>
                    @else
                        <div class="flex flex-col items-center">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
    class="h-[55dvh] w-[55dvh]">
    <path
        d="M7 20C7 17.2386 9.23858 15 12 15C14.7614 15 17 17.2386 17 20M7.2 20H16.8C17.9201 20 18.4802 20 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V7.2C20 6.0799 20 5.51984 19.782 5.09202C19.5903 4.71569 19.2843 4.40973 18.908 4.21799C18.4802 4 17.9201 4 16.8 4H7.2C6.0799 4 5.51984 4 5.09202 4.21799C4.71569 4.40973 4.40973 4.71569 4.21799 5.09202C4 5.51984 4 6.07989 4 7.2V16.8C4 17.9201 4 18.4802 4.21799 18.908C4.40973 19.2843 4.71569 19.5903 5.09202 19.782C5.51984 20 6.07989 20 7.2 20ZM14 10C14 11.1046 13.1046 12 12 12C10.8954 12 10 11.1046 10 10C10 8.89543 10.8954 8 12 8C13.1046 8 14 8.89543 14 10Z"
        stroke="" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        fill="#ffffff" />
</svg>

                            <p class="text-3xl font-bold text-white">No Account Was Assined In The Card </p>
                        </div>
                    @endif
                @else
                    <div class="flex flex-col items-center">
                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                        enable-background="new 0 0 512 512" xml:space="preserve" class="h-[55dvh] w-[55dvh] ">
                        <path
                            d="M499.5,385.4L308.9,57.2c-31.8-52.9-74.1-52.9-105.9,0L12.5,385.4c-31.8,52.9,0,95.3,63.5,95.3h360
                            C499.5,480.7,531.3,438.3,499.5,385.4z M298.4,438.3h-84.7v-84.7h84.7V438.3z M298.4,311.3h-84.7V120.7h84.7V311.3z"
                            fill="#ffffff" />
                    </svg>
                        <p class="text-3xl font-bold text-white">No card Found</p>
                    </div>
                @endif
            @else
                <div class="flex flex-col items-center">
                    <?xml version="1.0" encoding="utf-8"?>
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13 19.0008L17.8 19C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.0799 3 8.2V15M3 9H20M9 19.0008L3 19M9 19.0008L7 17M9 19.0008L7 21"
                            stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="h-[55dvh] w-[55dvh]" />
                    </svg>
                    <p class="text-3xl font-bold text-white">Scan Your Card at the Gate</p>
                </div>
            @endif
        </div>
    </div>
</div>
