<div>
    <h2
                            class="lg:text-2xl md:text-xl sm:text-lg font-semibold  uppercase text-yellow-500 lg:mt-2 md:mt-1 sm:mt-0.5">

                            @if($gate == 'Door1')
                                Gate 1
                                @elseif($gate == 'Door2')
                                Gate 2
                                @elseif($gate == 'Mobile')
                                Mobile
                                @else

                            @endif
                        </h2>
</div>