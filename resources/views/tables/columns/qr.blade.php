<div class="">

    <a href="{{route('download.qrcode',['idNumber'=> $getRecord()->id_number])}}">
        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG(strval($getRecord()->id_number), 'QRCODE') }}"
        alt="qrcode" class="h-10 w-10" />
    </a>


</div>