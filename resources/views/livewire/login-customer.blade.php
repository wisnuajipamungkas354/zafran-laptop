<div class="flex flex-col justify-center w-1/3 mx-auto bg-white">
    <img src="{{ asset('img/logo.png') }}" class="w-20 mx-auto mb-3" />
    <h2 class="mb-4 text-2xl font-bold text-center">Masuk ke Akun</h2>

    @error('email') <p class="pb-1 text-sm text-red-500">{{ $message }}</p> @enderror
    <form wire:submit.prevent="login" class="flex flex-col space-y-4">
        <input type="email" wire:model="email" placeholder="Email" class="w-full p-2 rounded border @error('email') border-red-500 @enderror" />

        <input type="password" wire:model="password" placeholder="Password" class="w-full p-2 rounded border @error('email') border-red-500 @enderror" />

        <button class="relative flex items-center justify-center px-4 py-2 text-white bg-blue-600 rounded">
            <img wire:loading src="{{ asset('img/spinner.svg') }}" class="absolute w-5 h-5 mr-16 animate-spin" /> Login
        </button>
    </form>

    <p class="mt-4 text-sm text-center">
        Belum punya akun?
        <a href="{{ route('register.customer') }}" wire:navigate class="text-blue-600 hover:underline">Daftar di sini</a>
    </p>
</div>
