<div class="mb-16 lg:mb-0">
    <div
      class="block h-full rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] ">
      <div class="flex justify-center">
        <div class="-mt-8 inline-block rounded-full p-4 text-primary shadow-md {{$color}} ">
            {{$slot}}
        </div>
      </div>
      <div class="p-6">
        <h3 class="mb-4 text-2xl font-bold text-primary ">
            {{$value}}
        </h3>
        <h5 class="mb-4 text-lg font-medium">{{$title}}</h5>
        <p class="text-neutral-500  capitalize">
            {{$description}}
        </p>
      </div>
    </div>
  </div>