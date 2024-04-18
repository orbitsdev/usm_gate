<div class="p-8 bg-white">



    <div>
        {{-- <h3 class="text-xl font-medium text-gray-900 ">

            Personal Information
          </h3> --}}
        <div class="mt-6 border-gray-100">
            <div class="col-span-3 mt-6">
                <a href="{{$record->getImage()}}" target="_blank" class="h-96 bg-gray-50 rounded">
                    <div class="w-full flex items-center justify-center">
                      <div class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-50">
                          <img src="{{$record->getImage()}}" alt="Off-white t-shirt with circular dot illustration on the front of mountain ridges that fade." class="object-cover object-center" style="max-height: 600px; width:100%">
                        </div>
                    </div>
                  </a>
            </div>
          <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Full name</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->getFullName()}}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Gender</dt>

              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->sex ?? ''}}
              </dd>

            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Birth Date</dt>

              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->birthDay()}}
              </dd>

            </div>

            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Account Type</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record->account_type ?? ''}}
              </dd>
            </div>

            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Address</dt>
  
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {{$record->address ?? ''}}
                </dd>
  
              </div>

            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Gender</dt>
  
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {{$record->address ?? ''}}
                </dd>
  
              </div>


             

        




          </dl>
        </div>


        
        
       
        @if($record->card)
        <div class="h-[4px] bg-gray-100"></div>

        <h3 class="text-lg font-medium text-gray-900 mt-6">

          Card Details
        </h3>

        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">ID Number</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record?->card?->id_number ?? ''}}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Valid Until</dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record?->card?->validUntil() }}
              </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium leading-6 text-gray-900">Status </dt>
              <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                {{$record?->card?->status ?? ''}}
              </dd>
            </div>
        </dl>
        @else

        <div class="h-44 rounded flex items-center justify-cente border bg-gray-50 w-full" style="height: 100px; ">

            <p class="text-center w-full">
                No Card Yet

            </p>

        </div>
          
        @endif
        
      </div>
      
</div>
