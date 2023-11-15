  
<div>
    

    @if ($transaction->success)
        <div class="w-full h-full flex flex-col justify-center items-center ">
            
                                
                @if ($transaction->card->account->image)
                <x-account-image :url="Storage::disk('public')->url($transaction->card->account->image)" />
            @else
                <x-no-image />
            @endif
                <div class="text-center">
                    <h1 class="lg:text-5xl md:text-4xl sm:text-3xl font-bold mt-6 mb-2 text-white capitalize">
                        {{ $transaction->card->account->last_name ?? '' }}, {{ $transaction->card->account->first_name ?? '' }} 
                    </h1>
                    <h2
                        class="text-center lg:text-2xl md:text-xl font-semibold text-white uppercase lg:mt-4 md:mt-3 sm:mt-2">
                        [ {{ $transaction->card->account->account_type ?? '' }} ]
                    </h2>
                    <div class="lg:mt-4 md:mt-3 sm:mt-2">
                        <h2 class="lg:text-5xl md:text-4xl sm:text-3xl font-bold uppercase {{ $transaction->scanned_type == 'entry' ? 'text-green-500' : ($transaction->scanned_type == 'exit' ? 'text-red-500' : 'text-gray-500') }}   ">

                            @if ($transaction->scanned_type == 'entry')
                Entering
            @elseif($transaction->scanned_type == 'exit')
                Exiting
            @else
                Cannot Define
            @endif

                        </h2>
                        <h2
                            class="lg:text-2xl md:text-xl sm:text-lg font-semibold  uppercase text-yellow-500 lg:mt-2 md:mt-1 sm:mt-0.5">

                            @if($transaction->door_name == 'Door1')
                                Gate 1
                                @elseif($transaction->door_name == 'Door2')
                                Gate 2
                                @elseif($transaction->door_name == 'Mobile')
                                Mobile
                                @else

                            @endif
                        </h2>

                        <p class="lg:text-lg md:text-md  lg:mt-4 md:mt-3 sm:mt-2 text-gray-300 max-w-lg leading-tight ">
                            @if ($transaction->error_type == 'multiple-entry-attempt' || $transaction->error_type == 'multiple-exit-attempt')
                            {{ $transaction->message }}
                        @endif
                        @if ($transaction->error_type == 'scanning-exit-no-entry-record')
                            {{ $transaction->message }}
                        @endif
                        </p>
                    </div>
                </div>
          </div>

          @else
          <x-warning-image>
            @if ($transaction->error_type == 'card-api-missing-parameter-in-java')
                {{ $transaction->message }}
                <x-gate-source :gate="$transaction->door_name"/>
                
            @elseif ($transaction->error_type == 'card-not-active')
                {{ $transaction->message }}
                  <x-gate-source :gate="$transaction->door_name"/>
            @elseif ($transaction->error_type == 'card-doesnt-have-account-assigned')
                {{ $transaction->message }}
                  <x-gate-source :gate="$transaction->door_name"/>
            @elseif($transaction->error_type == 'no-entry-record')
                {{ $transaction->message }}
                  <x-gate-source :gate="$transaction->door_name"/>
            @elseif($transaction->error_type == 'card-not-found')
                {{ $transaction->message }}
                  <x-gate-source :gate="$transaction->door_name"/>
            @elseif($transaction->error_type == 'invalid-exit-no-entry-found')
                {{ $transaction->message }}
                  <x-gate-source :gate="$transaction->door_name"/>
            @elseif($transaction->error_type == 'card-is-expired')
                {{ $transaction->message }}
                  <x-gate-source :gate="$transaction->door_name"/>
            @else
                Unidentified Error
                <x-gate-source :gate="$transaction->door_name"/>
            @endif
        </x-warning-image>
          @endif
        </div>
{{-- 
<div>
    @if ($transaction->success)
<div class="w-full h-full   flex flex-col justify-center items-center ">


      
    @if ($transaction->card->account->image)
    <x-account-image :url="Storage::disk('public')->url($transaction->card->account->image)" />
@else
    <x-no-image />
@endif

<div class="text-center">
    <h1 class="lg:text-5xl md:text-4xl sm:text-3xl font-bold mt-6 mb-2 text-white capitalize">
        {{ $transaction->card->account->last_name ?? '' }}, {{ $transaction->card->account->first_name ?? '' }} 
    </h1>
    <h2 class="text-center lg:text-2xl md:text-xl font-semibold text-white uppercase lg:mt-4 md:mt-3 sm:mt-2">
        [ {{ $transaction->card->account->account_type ?? '' }} ]
    </h2>
    <div class="lg:mt-4 md:mt-3 sm:mt-2">
        <h2 class="lg:text-5xl md:text-4xl sm:text-3xl font-bold uppercase {{ $transaction->scanned_type == 'entry' ? 'text-green-500' : ($transaction->scanned_type == 'exit' ? 'text-red-500' : 'text-gray-500') }} ">
            @if ($transaction->scanned_type == 'entry')
                Entering
            @elseif($transaction->scanned_type == 'exit')
                Exiting
            @else
                Cannot Define
            @endif
           
        </h2>
        <h2 class="lg:text-2xl md:text-xl sm:text-lg font-semibold  uppercase text-yellow-500 lg:mt-2 md:mt-1 sm:mt-0.5">
            ({{ $transaction->door_name ?? '' }})
        </h2>

        <p class="lg:text-xl md:text-lg sm:text-md lg:mt-4 md:mt-3 sm:mt-2 text-gray-300 ">
            @if ($transaction->error_type == 'multiple-entry-attempt' || $transaction->error_type == 'multiple-exit-attempt')
                {{ $transaction->message }}
            @endif
            @if ($transaction->error_type == 'scanning-exit-no-entry-record')
                {{ $transaction->message }}
            @endif
        </p>
    </div>
</div>

</div>

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

</div> --}}
