<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Keranjang Belanja Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (empty($cart))
                        <p>Keranjang belanja Anda masih kosong.</p>
                        <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800 mt-4 inline-block">Mulai Belanja</a>
                    @else
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Produk</th>
                                        <th scope="col" class="px-6 py-3">Harga</th>
                                        <th scope="col" class="px-6 py-3 text-center">Jumlah</th>
                                        <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach ($cart as $id => $details)
                                        @php
                                            $subtotal = $details['price'] * $details['quantity'];
                                            $grandTotal += $subtotal;
                                        @endphp
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 align-middle">
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $details['name'] }}</td>
                                            <td class="px-6 py-4">Rp {{ number_format($details['price'], 0, ',', '.') }}</td>
                                            <td class="px-6 py-4">
                                                {{-- Form untuk update quantity --}}
                                                <form action="{{ route('cart.update', $id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="w-20 text-center border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">
                                                    <button type="submit" class="ml-2 text-sm text-blue-500 hover:underline">Update</button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-center">
                                                {{-- Form untuk hapus item --}}
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="text-right mt-6">
                            <h3 class="text-xl font-bold">Grand Total: Rp {{ number_format($grandTotal, 0, ',', '.') }}</h3>
                            <a href="#" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Lanjut ke Checkout</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
