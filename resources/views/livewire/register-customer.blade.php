<div class="flex flex-col justify-center w-1/3 mx-auto bg-white">
    <img src="{{ asset('img/logo.png') }}" class="w-20 mx-auto mb-3" />
    <h2 class="mb-4 text-2xl font-bold text-center">Daftar Akun</h2>

    <form wire:submit.prevent="register" class="flex flex-col space-y-4">
        <input type="text" wire:model="first_name" placeholder="Nama Depan" class="w-full p-2 border rounded" />
        <input  type="text" wire:model="last_name" placeholder="Nama Belakang" class="w-full p-2 border rounded" />
        <input type="email" wire:model="email" placeholder="Email" class="w-full p-2 border rounded" />
        <input type="password" wire:model="password" placeholder="Password" class="w-full p-2 mt-8 border rounded" />
        <p class="text-xs text-gray-400">*Password minimal 6 karakter</p>
        <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-2 border rounded" />

        <button class="px-4 py-2 text-white bg-blue-600 rounded">Daftar</button>
    </form>

    <p class="mt-4 text-sm text-center">
        Sudah punya akun?
        <a href="{{ route('login.customer') }}" wire:navigate class="text-blue-600 hover:underline">Login di sini</a>
    </p>
</div>
