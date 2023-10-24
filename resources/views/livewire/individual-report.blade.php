<div>
    <x-live-wire-layout>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
    
                .b {
                    visibility: hidden;
                }
    
                .print-container,
                .print-container * {
                    visibility: visible;
                }
    
                .print-container {
                    color: black;
                    position: absolute;
                    top: 0;
                    left: 50%;
                    transform: translateX(-50%);
                }
            }
        </style>
        {{-- <form wire:submit="create">
            
            <button type="submit">
                Submit
            </button>
        </form> --}}
     
        {{ $this->form }}
        <div class=" flex justify-start w-full mt-6 ">
            <x-button rose  wire:click="exportToExcel" style="background: #03A340" icon="newspaper"
                class="mr-4">Export </x-button>
            <x-button rose  wire:click="print" style="background: #03A340" icon="printer">Print</x-button>
        </div>

        <div class="print-container  bg-white w-full ">
            <div class="flex justify-center p-6">
                <div class="mr-10">
                    <img src="{{ asset('images/usm-seal.png') }}" alt="" style="width: 60px; height: 60px">
                </div>
                <div class="text-center " style="padding: 0px  20px ">
                    <p>Republic of The Philippines</p>
                    <p class="uppercase">University of Southern Mindanao</p>
                    @if ($dayData)
                        <p class="mt-10 " style="padding-top: 20px"> {{ $dayData->created_at->format('F d, Y - l ') }} </p>
                    @else
                        {{-- <p class="mt-10 " style="padding-top: 20px"> {{ now()->format('F d, Y - l ') }} </p> --}}
                    @endif
                </div>
                <div class="ml-10">
                    <img src="{{ asset('images/usm-seal.png') }}" alt="" style="width: 60px; height: 60px">
                </div>
            </div>
    
    
        <table class="w-full divide-y divide-gray-300 mt-6">
            @if (count($records) > 0)
                <thead>
                    <tr>
                        <th scope="col" class="py-2 pr-3 text-left text-xs font-semibold sm:pl-6  "
                            style="padding-left: 16px;">Day</th>
                        <th scope="col" class="py-2 pr-3 text-left text-xs font-semibold sm:pl-6  "
                            style="padding-left: 16px;">Account</th>
                        <th scope="col" class="px-3 py-2 text-left text-xs font-semibold" style="padding-left: 16px;">
                            Card ID</th>
                        <th scope="col" class="px-3 py-2 text-left text-xs font-semibold" style="padding-left: 16px;">
                            Account Type</th>
                        <th scope="col" class="px-3 py-2 text-center text-xs font-semibold">Time In</th>
                        <th scope="col" class="px-3 py-2 text-center text-xs font-semibold">Time Out </th>
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-gray-200">
                @forelse ($records as $item)
                    <tr>
                        <td class="whitespace-normal py-2 pr-3 text-left text-xs font-medium"
                            style="padding-left: 16px;">
                            @if (!empty($item->day))
                                {{$item->day->created_at->format('F d, Y - l')}}
                            @else
                                No Card Found
                            @endif
                        </td>
                        <td class="whitespace-normal py-2 pr-3 text-left text-xs font-medium"
                            style="padding-left: 16px;">
                            @if (!empty($item->card))
                                @if (!empty($item->card->account))
                                    {{ $item->card->account->last_name . ', ' ?? '' }}
                                    {{ $item->card->account->first_name }} {{ $item->card->account->middle_name }}
                                @else
                                    No Account Found
                                @endif
                            @else
                                No Card Found
                            @endif
                        </td>
                        <td class="whitespace-normal py-2 pr-3 text-left text-xs font-medium"
                            style="padding-left: 16px;">
                            @if (!empty($item->card))
                                {{ $item->card->id_number }}
                            @else
                                No Card Found
                            @endif
                        </td>
                        <td class="whitespace-normal py-2 pr-3 text-left text-xs font-medium"
                            style="padding-left: 16px;">
                            @if (!empty($item->card))
                                @if (!empty($item->card->account))


                                    {{ $item->card->account->account_type ?? '' }}
                                  
                                @else
                                    No Account Found
                                @endif
                            @else
                                No Card Found
                            @endif
                        </td>
                        <td class="whitespace-normal py-2 pr-3 text-center text-xs font-medium"
                            style="padding-left: 16px;">

                            @if ($item->entry)
                                {{ $item->created_at->format('h:i:s A') }}
                            @else
                                None
                            @endif

                        </td>
                        <td class="whitespace-normal py-2 pr-3 text-center text-xs font-medium"style="padding-left: 16px;">

                            @if ($item->entry == true && $item->exit == true)
                                {{ $item->updated_at->format('h:i:s A') }}
                            @else
                            -- Currently Inside -- 
                            @endif

                        </td>
                    </tr>
                @empty
                    <div class="text-center flex justify-center w-full" style="padding: 20px 20px 50px 20px">
                        <p class="text-lg font-bold text-center" style="padding: 20px">No record found</p>
                    </div>
                @endforelse
            </tbody>
        </table>

    </div>

        <x-filament-actions::modals />
    </x-live-wire-layout>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('printIndividualTable', (event) => {
                window.print();
            });
        });
    </script>
    
    

    
</div>
