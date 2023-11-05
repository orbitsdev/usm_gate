<div class="relative bg-cover bg-center bg-no-repeat font-sans flex items-center justify-center h-screen " style="background-image: url('{{ asset('images/usmbg.png') }}');">
    <div class="absolute inset-0 bg-gradient-to-b from-[#13140f77] to-[#1a1a09]"></div>
    <div class="absolute z-2 top-5 left-5">
        @livewire('date-text')
</div>
    <div wire:poll.1s.visible class="relative z-10">
        <div class=" rounded max-w-7xl w-full h-full text-center ">
            @if ($transaction)
                @if ($transaction->success)
                    @if($transaction->card->account)
                        <div class="flex flex-col items-center">
                        
                        @if ($transaction->card->account->image)
                            <x-account-image :url="Storage::disk('public')->url($transaction->card->account->image)" />
                        @else
                            <x-no-image />
                        @endif
                        <div class="text-center">
                            <h1 class="text-6xl font-bold mt-6 mb-2 text-white capitalize">
                                {{ $transaction->card->account->last_name ?? '' }}, {{ $transaction->card->account->first_name ?? '' }} AgaSIne Asamele
                            </h1>
                            <h2 class="text-center text-3xl font-semibold text-white  uppercase mt-6">
                                ( {{ $transaction->card->account->account_type ?? '' }} )
                            </h2>
                            <div class="mt-4">
                                <h2 class="text-6xl font-bold  uppercase {{ $transaction->scanned_type == 'entry' ? 'text-green-500' : ($transaction->scanned_type == 'exit' ? 'text-red-500' : 'text-gray-500') }}">
                                    @if ($transaction->scanned_type == 'entry')
                                        Entering
                                    @elseif($transaction->scanned_type == 'exit')
                                        Exiting
                                    @else
                                        Cannot Define
                                    @endif
                                </h2>
                                {{-- <h2 class="text-2xl font-semibold  uppercase text-yellow-500 mt-2">
                                    {{ \Carbon\Carbon::parse($transaction->updated_at)->format('l h:i A') }}
                                </h2> --}}
                                <p class="text-lg mt-4 text-gray-300 ">
                                    @if ($transaction->error_type == 'multiple-entry-attempt' || $transaction->error_type == 'multiple-exit-attempt')
                                        {{ $transaction->message }}
                                    @endif
                                    @if ($transaction->error_type == 'scannining-exit-no-entry-record')
                                        {{ $transaction->message }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        
                        
                        {{-- <div>
                            <h2 class="text-6xl font-bold mb-2 mt-8 text-white capitalize">
                                {{ $transaction->card->account->last_name ?? '' }},
                                {{ $transaction->card->account->first_name ?? '' }}
                            </h2>
                            <div class="flex items-center justify-center mb-4 mt-8">
                                <div class="p-4 bg-green-600 rounded-full">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                                        @if ($transaction->scanned_type == 'entry')
                                            <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        @elseif($transaction->scanned_type == 'exit')
                                            <path d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        @else
                                            <circle cx="12" cy="12" r="10"></circle>
                                        @endif
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold ml-2 text-white uppercase">
                                    @if ($transaction->scanned_type == 'entry')
                                        Entering
                                    @elseif($transaction->scanned_type == 'exit')
                                        Exiting
                                    @else
                                        Cannot Define
                                    @endif
                                </h2>
                            </div>
                            <h2 class="text-3xl font-bold mb-2 mt-8 text-white p-2 rounded  uppercase">
                                {{ \Carbon\Carbon::parse($transaction->updated_at)->format('l h:i:s A') }}
                            </h2>
                            <h2 class="text-xl font-bold mb-2 mt-8 text-white p-2 rounded  uppercase max-w-[30dvw] mx-auto">
                                @if ($transaction->error_type == 'multiple-entry-attempt' || $transaction->error_type == 'multiple-exit-attempt')
                                    {{ $transaction->message }}
                                @endif
                            </h2>
                        </div> --}}
                    </div>

                    @else
                    <x-warning-image>
                      
                            No acccount was assigned to card
                    </x-warning-image>
                    @endif
                @else
                    <x-warning-image>
                        @if ($transaction->error_type == 'card-api-missing-parameter-in-java')
                            {{ $transaction->message }}
                        @elseif ($transaction->error_type == 'card-not-active')
                            {{ $transaction->message }}
                        @elseif ($transaction->error_type == 'card-doesnt-have-account-assigned')
                            {{ $transaction->message }}
                        @elseif($transaction->error_type == 'no-entry-record')
                            {{ $transaction->message }}
                        @elseif($transaction->error_type == 'card-not-found')
                            {{ $transaction->message }}
                        @elseif($transaction->error_type == 'invalid-exit-no-entry-found')
                            {{ $transaction->message }}
                        @elseif($transaction->error_type == 'card-is-expired')
                            {{ $transaction->message }}
                        @else
                            Unidentified Error
                        @endif
                    </x-warning-image>
                @endif
            @else
                <x-default-display-image>
                    Scan Your Card At Door 2
                </x-default-display-image>
            @endif
        </div>
    </div>
</div>
