<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Notifikasi Sukses dari proses checkout --}}
                    @if (session('success'))
                        <div
                            x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-bold">Invoice: {{ $order->invoice_number }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal: {{ $order->created_at->format('d F Y, H:i') }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Status: <span class="font-semibold capitalize px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs">{{ $order->status }}</span></p>
                        </div>
                        <div class="text-right">
                            <h4 class="font-bold">Ditagih Kepada:</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->user->email }}</p>
                        </div>
                    </div>

                    <hr class="my-6 dark:border-gray-700">

                    <h4 class="font-bold mb-4">Rincian Barang:</h4>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Produk</th>
                                    <th scope="col" class="px-6 py-3 text-center">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-right">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</td>
                                        <td class="px-6 py-4 text-center">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="font-semibold text-gray-900 dark:text-white">
                                    <th scope="row" colspan="3" class="px-6 py-3 text-base text-right">Total Belanja</th>
                                    <td class="px-6 py-3 text-base text-right">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('products.index') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Kembali Belanja
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
