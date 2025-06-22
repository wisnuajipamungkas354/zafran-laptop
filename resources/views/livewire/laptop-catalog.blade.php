@push('style')
<!-- Swiper CSS -->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush

<div class="container px-6 py-8 mx-auto">
    <div>
        {{-- Banner Slider --}}
        <div class="mb-8">
            <div class="overflow-hidden shadow swiper bannerSwiper rounded-2xl">
                <div class="swiper-wrapper">
                    {{-- Ganti URL gambar sesuai kebutuhan --}}
                    <div class="swiper-slide">
                        <img src="{{ asset('img/banner1.webp') }}" class="object-cover w-full h-48 md:h-[500px]" alt="Banner 1">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('img/banner2.webp') }}" class="object-cover w-full h-48 md:h-[500px]" alt="Banner 2">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('img/banner3.webp') }}" class="object-cover w-full h-48 md:h-[500px]" alt="Banner 3">
                    </div>
                </div>
                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Katalog Laptop</h1>
        {{-- @livewire('navbar') --}}
    </div>

    {{-- Grid katalog laptop --}}
    @if($laptops->isEmpty())
        <div class="mt-8 text-center text-gray-500">
            Tidak ada laptop yang ditemukan.
        </div>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @foreach($laptops as $laptop)
                <div class="overflow-hidden transition bg-white shadow rounded-2xl hover:shadow-md">
                    <a href="{{ route('katalog.detail', $laptop->id) }}" wire:navigate>
                        <img src="{{ asset('storage/' . $laptop->laptop_images[0] ?? 'img/default.png') }}"
                             alt="{{ $laptop->model }}"
                             class="object-cover w-full h-64">
                    </a>

                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-600 uppercase">
                            {{ $laptop->brand->brand_name ?? 'Unknown Brand' }}
                        </h3>
                        <p class="text-lg font-bold text-gray-800 uppercase">
                            {{ $laptop->model }}
                        </p>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $laptop->processor }} | {{ $laptop->ram }} RAM
                        </p>
                        <p class="mt-2 text-lg font-semibold text-blue-600">
                            Rp{{ number_format($laptop->price, 0, ',', '.') }}
                        </p>
                        <a href="{{ route('katalog.detail', $laptop->id) }}" wire:navigate
                           class="inline-block w-full py-2 mt-3 text-sm text-center text-white transition bg-blue-600 rounded-xl hover:bg-blue-700">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper(".bannerSwiper", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    });
</script>
@endpush