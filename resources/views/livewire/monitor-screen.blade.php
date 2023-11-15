<div class="relative bg-gray-700 w-full h-screen bg-cover bg-center bg-no-repeat font-sans"
    style="background-image: url('{{ asset('images/usmbg.png') }}');">
    <div class="absolute z-0 inset-0 bg-gradient-to-b from-[#13140f77] to-[#1a1a09]"></div>
    <div class="absolute left-20 top-4 text-center z-10">
        @livewire('date-text')
    </div>

    {{-- <div class=" h-full z-10">
        <div class="h-full relative gap-x-1 grid grid-cols-1">



            <div class="w-full h-full flex flex-col justify-center items-center ">
             
                <x-no-image />
                <div class="text-center">
                    <h1 class="lg:text-5xl md:text-4xl sm:text-3xl font-bold mt-6 mb-2 text-white capitalize">
                        Maria Clasra Flor Mane Jesicae
                    </h1>
                    <h2
                        class="text-center lg:text-2xl md:text-xl font-semibold text-white uppercase lg:mt-4 md:mt-3 sm:mt-2">
                        [Student]
                    </h2>
                    <div class="lg:mt-4 md:mt-3 sm:mt-2">
                        <h2 class="lg:text-5xl md:text-4xl sm:text-3xl font-bold uppercase  text-green-500  ">

                            Entering

                        </h2>
                        <h2
                            class="lg:text-2xl md:text-xl sm:text-lg font-semibold  uppercase text-yellow-500 lg:mt-2 md:mt-1 sm:mt-0.5">
                            MOBILE
                        </h2>

                        <p class="lg:text-xl md:text-lg sm:text-md lg:mt-4 md:mt-3 sm:mt-2 text-gray-300 ">
                            Multipe Attemp
                        </p>
                    </div>
                </div>
            </div>









        </div>
    </div> --}}
    <div wire:poll.1s class=" h-full z-10  ">

        @if (count($transactions) > 0)
            <div class=" relative gap-x-1 grid grid-cols-{{ min(3, count($transactions)) }} h-full z-10">
                @foreach ($transactions as $transaction)
                    <x-user-profile :transaction="$transaction" />
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-screen text-white relative">
                <img src="{{ asset('images/usm-kidapawan-logo.png') }}" alt="USM Kidapawan Logo"
                    class="mb-8 w-[260px] h-[260px]">

                <h1 class="text-7xl font-bold mb-4 max-w-7xl text-center  ">University of Southern Mindanao</h1>
                <h1 class="text-6xl font-bold mb-4 max-w-6xl text-center uppercase  text-gray-200">( Kidapawan Campus )
                </h1>

                <p class="text-2xl text-center max-w-5xl mb-8  font-serif   capitalize mt-6 leading-relaxed">


                    "Embark on your academic adventure at the University of Southern Mindanao, Kidapawan Campus! Uncover
                    endless opportunities, immerse yourself in our lively community, and let's shape a future full of
                    possibilities together. Your journey begins here!"
                </p>

                {{-- <div class="p-4 rounded-md">
                <p class="text-sm text-gray-400">
                    Enriching Lives, Empowering Futures
                </p>
            </div> --}}

            </div>





            {{-- <x-default-display-image>
                Scan Your Card
            </x-default-display-image>

            <div class="flex flex-col h-full items-center justify-center relative">
                <img src="{{asset('images/sample-profile.jpg')}}"  alt="Attendee Image" class="w-full h-full lg:max-w-[590px] lg:max-h-[500px] md:max-w-[450px] md:max-h-[350px] sm:max-w-[350px] sm:max-h-[250px] max-w-[150px] max-h-[150px] rounded-md object-cover ">
            </div> --}}
        @endif
    </div>
</div>





{{-- <div class="relative bg-cover bg-center bg-no-repeat font-sans flex items-center justify-center h-screen " style="background-image: url('{{ asset('images/usmbg.png') }}');">
    <div class="absolute inset-0 bg-gradient-to-b from-[#13140f77] to-[#1a1a09]"></div>
    <div class="absolute z-2 top-5 left-5">
            @livewire('date-text')
    </div>
    
    
    <div wire:poll.1s.visible class="relative z-10">
        <div class="bg-red-400 rounded  text-center ">
            @if ($transaction)
                @if ($transaction->success)
                    @if ($transaction->card->account)
                        <div class="flex flex-col items-center">
                        
                        @if ($transaction->card->account->image)
                            <x-account-image :url="Storage::disk('public')->url($transaction->card->account->image)" />
                        @else
                            <x-no-image />
                        @endif
                        <div class="text-center">
                            <h1 class="text-6xl font-bold mt-6 mb-2 text-white capitalize">
                                {{ $transaction->card->account->last_name ?? '' }}, {{ $transaction->card->account->first_name ?? '' }} 
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
                                <h2 class="text-2xl font-semibold  uppercase text-yellow-500 mt-2">
                                    {{ \Carbon\Carbon::parse($transaction->updated_at)->format('l h:i:s A') }}
                                </h2>
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
                Scan Your Card At Door 1
            </x-default-display-image>
            @endif
        </div>
    </div>
</div> --}}
