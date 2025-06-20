<div class="w-1/3 mx-auto bg-white flex flex-col justify-center">
    <img src="{{ asset('img/logo.png') }}" class="mx-auto w-20 mb-3" />
    <h2 class="text-2xl font-bold mb-4 text-center">Daftar Akun</h2>

    <form wire:submit.prevent="register" class="space-y-4 flex flex-col">
        <input type="text" wire:model="first_name" placeholder="Nama Depan" class="w-full border p-2 rounded" />
        <input  type="text" wire:model="last_name" placeholder="Nama Belakang" class="w-full border p-2 rounded" />
        <input type="email" wire:model="email" placeholder="Email" class="w-full border p-2 rounded" />
        <input type="password" wire:model="password" placeholder="Password" class="w-full border p-2 rounded" />
        <input type="password" wire:model="password_confirmation" placeholder="Konfirmasi Password" class="w-full border p-2 rounded" />

        <button class="bg-blue-600 text-white py-2 px-4 rounded">Daftar</button>
    </form>

    <p class="text-sm text-center mt-4">
        Sudah punya akun?
        <a href="{{ route('login.customer') }}" wire:navigate class="text-blue-600 hover:underline">Login di sini</a>
    </p>
</div>
