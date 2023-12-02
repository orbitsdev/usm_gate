<div class="">
    @if(!empty($getRecord()->qr_number))
        
    <a href="{{route('download.qrcode',['idNumber'=> $getRecord()->qr_number])}}">
        {{-- <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG(strval($getRecord()->qr_number), 'QRCODE') }}" --}}
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG($getRecord()->qr_number, 'QRCODE') }}"
        alt="qrcode" class="h-10 w-10" />
    </a>

    @else

    @endif


</div>