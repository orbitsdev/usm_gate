
  <div class="bg-white p-6 rounded-lg shadow-[0_2px_8px_-3px_rgba(0,0,0,0.07),0_8px_10px_-2px_rgba(0,0,0,0.04)]  transition  hover:bg-gray-50 ">
    <div class="flex items-center mb-4">
        <div class="p-2 rounded-full flex items-center justify-center ">
       {{$slot}}
        </div>
        <h3 class="text-xl font-semibold ml-3">{{$title}}</h3>
    </div>
    <p class="text-3xl">{{$value}}</p>
</div>