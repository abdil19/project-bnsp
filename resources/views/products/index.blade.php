<x-app-layout>
<x-slot name="header">
<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
{{ __('Daftar Produk') }}
</h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Notifikasi Keranjang --}}
                    @if (session('success'))
                    <div
                        x-data="{ show: true }"
                        x-init="setTimeout(() => show = false, 2000)"
                        x-show="show"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert"
                    >
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                    @endif

                    {{-- Grid untuk menampilkan produk --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div class="border dark:border-gray-700 rounded-lg p-4 flex flex-col justify-between">
                                <div>

                                    {{-- Placeholder untuk gambar produk --}}
                                    @if ($product->image)
                                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="h-48 w-full object-cover mb-4 rounded">
                                    @else
                                        <div class="bg-gray-200 dark:bg-gray-700 h-48 w-full mb-4 rounded flex items-center justify-center">
                                            <span class="text-gray-500 text-sm">Tanpa Gambar</span>
                                        </div>
                                    @endif
                                    <h3 class="font-bold text-lg mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                        {{ Str::limit($product->description, 50) }}
                                    </p>
                                </div>

                                <div class="mt-auto">
                                    <div class="flex justify-between items-center">
                                        <span class="font-extrabold text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500">Stok: {{ $product->stock }}</span>
                                    </div>

                                    {{-- Button Keranjang --}}
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                            {{-- Tombol Add to Cart --}}
                                            <button type="submit" class="w-full text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                                Add to Cart
                                            </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Link Paginasi --}}
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```
