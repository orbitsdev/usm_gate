<div class="min-h-screen flex flex-col items-center justify-center relative" style="background: url('{{ '' }}') center/cover no-repeat;">
    <div class="absolute inset-0 bg-gradient-to-b from-yellow-500 to-yellow-900 opacity-50"></div>

    <div class="w-full max-w-md px-6 py-4 bg-white text-black shadow-md sm:rounded-lg z-10 relative pt-12">
        <p class="text-center font-bold mt-4 uppercase text-xl">USM ATTENDANCE</p>
        <div class="mb-4 absolute left-1/2 top-[-60px] -translate-x-1/2 transform">
            {{ $logo }}
        </div>
        {{ $slot }}
    </div>
</div>
