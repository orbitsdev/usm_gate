<div class=" bg-white grid grid-cols-12">


  @if($record->account)
  <div class="col-span-12">

    <a href="{{$record->account->getImage()}}" target="_blank" class="h-96 bg-gray-50 rounded">
      <img src="{{$record->account->getImage()}}" alt="Off-white t-shirt with circular dot illustration on the front of mountain ridges that fade.">
      
      
    </a>
  </div>
    @endif

        <div class=" border-gray-100 col-span-9">  
            
          

           
          
          <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Card Owner</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $record->account ? $record->account->getFullName() : 'None' }}
                </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Account Type</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    {{ $record->account ? $record->account->account_type ?? '' : '' }}
                </dd>
            </div>
            
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">RF ID</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {{$record?->id_number ?? ''}}
                </dd>
              </div>
            
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">School ID</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {{$record?->qr_number ?? ''}}
                </dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Expiration Date</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {{$record?->validUntil() }}
                </dd>
              </div>
              <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                <dt class="text-sm font-medium leading-6 text-gray-900">Status </dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                  {{$record?->status ?? ''}}
                </dd>
              </div>


             

        




          </dl>
        </div>


        
       
        {{-- <div class="col-span-3 flex items-center justify-center ">
          @if(!empty($record->qr_number))
        
          <a href="{{route('download.qrcode',['idNumber'=> $record->qr_number])}}" class="block">
           

              <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($record->qr_number, 'QRCODE') }}" alt="qrcode" class="qr-code-img" />

          </a>
      
          @else
      
          @endif
        </div>
         --}}
    
         <div class="col-span-3 flex flex-col items-center justify-center ">
          @if(!empty($record->qr_number))
              <a href="{{route('download.qrcode',['idNumber'=> $record->qr_number])}}" class="block">
                  <div class="qr-code-container">
                      <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($record->qr_number, 'QRCODE') }}" alt="qrcode" class="qr-code-img" />
                      <div class="qr-code-value text-center text-lg mt-2 "> <span class="">
                        {{ $record->qr_number }}
                        </span>
                        </div>
                  </div>
              </a>
          @else
              <!-- Handle case where QR code number is empty -->
          @endif
      </div>
      
      
</div>
