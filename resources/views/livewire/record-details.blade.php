<div class="p-8 bg-white">





    <div class=" border-gray-100">
        @if ($record->card)
            @if ($record->card->account)
                <a href="{{ $record->card->account->getImage() }}" target="_blank" class="h-96 bg-gray-50 rounded">
                    <img src="{{ $record->card->account->getImage() }}"
                        alt="Off-white t-shirt with circular dot illustration on the front of mountain ridges that fade.">


                </a>
            @endif

        @endif


        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Date </dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $record->dayDate() }}
                </dd>
            </div>
            @if ($record->card)

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Card ID</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $record->card->id_number ?? '' }}
                    </dd>
                </div>
                @if ($record->card->account)
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900">Owner</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                            {{ $record->card->account->getFullName() }}
                        </dd>
                    </div>
                @endif

                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Time Enter</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $record->recordAt() ?? '' }}
                    </dd>
                </div>
                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium leading-6 text-gray-900">Time Exit</dt>
                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ $record->updateAt() ?? '' }}
                    </dd>
                </div>
            @endif



        </dl>
    </div>

</div>
