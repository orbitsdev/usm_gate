<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
<div>
    <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
    <div class="relative  lg:hidden" role="dialog" aria-modal="true">
      <!--
        Off-canvas menu backdrop, show/hide based on off-canvas menu state.
  
        Entering: "transition-opacity ease-linear duration-300"
          From: "opacity-0"
          To: "opacity-100"
        Leaving: "transition-opacity ease-linear duration-300"
          From: "opacity-100"
          To: "opacity-0"
      -->
      <div class="fixed inset-0 bg-gray-900/80"></div>
  
      <div class="fixed inset-0 flex">
        <!--
          Off-canvas menu, show/hide based on off-canvas menu state.
  
          Entering: "transition ease-in-out duration-300 transform"
            From: "-translate-x-full"
            To: "translate-x-0"
          Leaving: "transition ease-in-out duration-300 transform"
            From: "translate-x-0"
            To: "-translate-x-full"
        -->
        <div class="relative mr-16 flex w-full max-w-xs flex-1">
          <!--
            Close button, show/hide based on off-canvas menu state.
  
            Entering: "ease-in-out duration-300"
              From: "opacity-0"
              To: "opacity-100"
            Leaving: "ease-in-out duration-300"
              From: "opacity-100"
              To: "opacity-0"
          -->
          <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
            <button type="button" class="-m-2.5 p-2.5">
              <span class="sr-only">Close sidebar</span>
              <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
  
          <!-- Sidebar component, swap this element with another sidebar if you like -->
          <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
              
              <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=yellow&shade=600" alt="Your Company">
            </div>
            <nav class="flex flex-1 flex-col  ">
              <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                  <ul role="list" class="-mx-2 space-y-1">
                    <li>
                      <!-- Current: "bg-gray-50 text-yellow-600", Default: "text-gray-700 hover:text-yellow-600 hover:bg-gray-50" -->
                      <a href="#" class="bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Accounts
                      </a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                       Cards
                      </a>
                    </li>
                    
                  </ul>
                </li>
                <li>
                  <div class="text-xs font-semibold leading-6 text-gray-400">YourCardss</div>
                  <ul role="list" class="-mx-2 mt-2 space-y-1">
                    <li>
                      <!-- Current: "bg-gray-50 text-yellow-600", Default: "text-gray-700 hover:text-yellow-600 hover:bg-gray-50" -->
                      <a href="#" class="text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white text-gray-400 border-gray-200 group-hover:border-yellow-600 group-hover:text-yellow-600">H</span>
                        <span class="truncate">Heroicons</span>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white text-gray-400 border-gray-200 group-hover:border-yellow-600 group-hover:text-yellow-600">T</span>
                        <span class="truncate">Tailwind Labs</span>
                      </a>
                    </li>
                    <li>
                      <a href="#" class="text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white text-gray-400 border-gray-200 group-hover:border-yellow-600 group-hover:text-yellow-600">W</span>
                        <span class="truncate">Workcation</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="mt-auto">
                  <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-yellow-600">
                    <svg class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                  </a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  
    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0  lg:flex lg:w-72 lg:flex-col">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
        <div class="flex h-16 shrink-0 items-center">
          <img class="h-12 w-12" src="{{asset('images/usm-seal.png')}}" alt="Your Company"> <span class="font-bold ml-4 text-lg  text-gray-700">USM ATTENDANCE</span>
        </div>
        <nav class="flex flex-1 flex-col">
          <ul role="list" class="flex flex-1 flex-col gap-y-7">
            <li>
              <ul role="list" class="-mx-2 space-y-1">
                <li>
                  <!-- Current: "bg-gray-50 text-yellow-600", Default: "text-gray-700 hover:text-yellow-600 hover:bg-gray-50" -->
                  <a href="{{route('accounts')}}"  class="{{request()->routeIs('accounts') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0 ">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                      </svg>
                      
                    Accounts
                  </a>
                </li>
                <li>
                  <a href="{{route('cards')}}"  class="{{request()->routeIs('cards') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                      </svg>
                      
                   Cards
                  </a>
                </li>
                
                <li>
                  <a href="{{route('realtime-records')}}"  class="{{request()->routeIs('realtime-records') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                 
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                      </svg> --}}

                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                      </svg>
                      
                      
                      Realtime Statistics
                  </a>
                </li>
                <li>
                  <a href="{{route('days')}}"  class="{{request()->routeIs('days') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                 
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                      </svg> --}}


                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                      </svg>
                      
                      {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                      </svg> --}}
                      
                      
                     Daily Records
                  </a>
                </li>      
                   <div class="text-xs font-semibold leading-6 text-gray-400">Reports</div>
                <li>
                  <a href="{{route('overall-report')}}"  class="{{request()->routeIs('overall-report') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                 
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                      </svg> --}}


                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                      </svg>
                      
                      
                      Overall Report
                      
                      
                      {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                      </svg> --}}
                      
                      
                  
                  </a>
                </li>      
                <li>
                  <a href="{{route('individual-report')}}"  class="{{request()->routeIs('individual-report') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                 
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                      </svg> --}}


                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                      </svg>
                      
                      Individual Report
                      
                      
                      {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                      </svg> --}}
                      
                      
                  
                  </a>
                </li>                
                      
              </ul>
            </li>

            
           <li>
            <a href="{{ route('transactions') }}" class="{{ request()->routeIs('transactions') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' : 'text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}">
              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border {{ request()->routeIs('transactions') ? 'border-yellow-600' : '' }} text-[0.625rem] font-medium">S</span>
              <span class="truncate">Developer Debugging</span>
          </a>
              {{-- <div class="text-xs font-semibold leading-6 text-gray-400">Reports</div>
              <ul role="list" class="-mx-2 mt-2 space-y-1">
                <li>
              
                  <a href="{{route('days')}}"  class="{{(request()->routeIs('days') || request()->routeIs('day-view-record'))  ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border {{(request()->routeIs('days') || request()->routeIs('day-view-record')) ? 'border-yellow-600': ''}} text-[0.625rem] font-medium ">D</span>
                    <span class="truncate">Daily Records</span>
                  </a>
                </li>
                <li>
               
                  <a href="{{route('days')}}"  class="{{(request()->routeIs('days') || request()->routeIs('day-view-record'))  ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border {{(request()->routeIs('days') || request()->routeIs('day-view-record')) ? 'border-yellow-600': ''}} text-[0.625rem] font-medium ">D</span>
                    <span class="truncate">OverAll Report</span>
                  </a>
                </li>
                <li>
                 
                  <a href="{{route('days')}}"  class="{{(request()->routeIs('days') || request()->routeIs('day-view-record'))  ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold': ' text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}  ">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border {{(request()->routeIs('days') || request()->routeIs('day-view-record')) ? 'border-yellow-600': ''}} text-[0.625rem] font-medium ">D</span>
                    <span class="truncate">Individual Report</span>
                  </a>
                </li> 
                
                 <li>
                  <a href="{{ route('logs') }}" class="{{ request()->routeIs('logs') ? 'bg-gray-50 text-yellow-600 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' : 'text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold' }}">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border {{ request()->routeIs('logs') ? 'border-yellow-600' : '' }} text-[0.625rem] font-medium">H</span>
                    <span class="truncate">Api & Hardware Logs</span>
                </a>
                
                </li>
                <li>
                
                
                </li>


                
                  <li>
                  <a href="#" class="text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white text-gray-400 border-gray-200 group-hover:border-yellow-600 group-hover:text-yellow-600">T</span>
                    <span class="truncate">Tailwind Labs</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="text-gray-700 hover:text-yellow-600 hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white text-gray-400 border-gray-200 group-hover:border-yellow-600 group-hover:text-yellow-600">W</span>
                    <span class="truncate">Workcation</span>
                  </a>
                </li> 
               
              </ul> --}}
            </li>
           
          </ul>
        </nav>
      </div>
    </div>
  
    <div class="lg:pl-72 z-40">
      <div class="sticky top-0  flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white  z-20 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
        <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
          <span class="sr-only">Open sidebar</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
  
        <!-- Separator -->
        <div class="h-6 w-px bg-gray-200 lg:hidden" aria-hidden="true"></div>
  
        <div class=" flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
          <div class="flex-1"></div>
          <div class="flex items-center gap-x-4 lg:gap-x-6">
            {{-- <button type="button" class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
              <span class="sr-only">View notifications</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
              </svg>
            </button> --}}
  
            <!-- Separator -->
            <div class="hidden  lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true"></div>
  
            
            <div x-data="{ isOpen: false }" class="relative">
                <button type="button" @click="isOpen = !isOpen" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <span class="sr-only">Open user menu</span>
                    {{-- <img class="h-8 w-8 rounded-full bg-gray-50" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt=""> --}}
                    <div class="h-8 w-8 rounded-full bg-yellow-600 text-white flex items-center justify-center">
                      <p class="m-0 p-0 ">
                        A
                      </p>
                    </div>
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{auth()->user()->name}}</span>
                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
            
                <div x-show="isOpen" @click.away="isOpen = false" class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <!-- Active: "bg-gray-50", Not Active: "" -->
                    <a href="#" class="block px-3 py-1 text-sm leading-6 text-gray-900" role="menuitem" tabindex="-1" id="user-menu-item-0">Your profile</a>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-dropdown-link href="{{ route('logout') }}"
                                 @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                    
                </div>
            </div>
            
          </div>
        </div>
      </div>
  
      <main class="py-10">
        <div class="px-4 sm:px-6 lg:px-8">

            {{$slot}}
          <!-- Your content -->
        </div>
      </main>
    </div>
  </div>
  