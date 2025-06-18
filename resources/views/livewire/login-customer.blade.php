<div class="w-1/3 mx-auto bg-white flex flex-col justify-center">
    <img src="{{ asset('img/logo.png') }}" class="mx-auto w-20 mb-3" />
    <h2 class="text-2xl font-bold mb-4 text-center">Masuk ke Akun</h2>

    @error('email') <p class="text-red-500 text-sm pb-1">{{ $message }}</p> @enderror
    <form wire:submit.prevent="login" class="space-y-4 flex flex-col">
        <input type="email" wire:model="email" placeholder="Email" class="w-full border p-2 rounded @error('email') border border-red-500 @enderror" />

        <input type="password" wire:model="password" placeholder="Password" class="w-full border p-2 rounded @error('email') border border-red-500 @enderror" />

        <button class="bg-blue-600 text-white py-2 px-4 rounded">Login</button>
    </form>

    <p class="text-sm text-center mt-4">
        Belum punya akun?
        <a href="{{ route('register.customer') }}" wire:navigate class="text-blue-600 hover:underline">Daftar di sini</a>
    </p>
</div>
