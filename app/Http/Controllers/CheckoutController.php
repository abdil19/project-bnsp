<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;     // Penting untuk Transaksi
use Illuminate\Support\Facades\Auth;    // Untuk mendapatkan user yang login

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = session('cart', []);

        // Jangan proses jika keranjang kosong
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong!');
        }

        // Mulai Transaksi Database untuk menjaga keamanan data
        DB::beginTransaction();

        try {
            // Hitung total belanja dari session cart
            $totalAmount = collect($cart)->sum(function($item) {
                return $item['price'] * $item['quantity'];
            });

            // 1. Buat record di tabel 'orders'
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'invoice_number' => 'INV-' . time() . '-' . $user->id,
                'status' => 'paid',
            ]);

            // 2. Loop dan buat record di tabel 'order_items' & update stok
            foreach ($cart as $id => $details) {
                $product = Product::find($id);

                // Cek stok untuk keamanan
                if ($product->stock < $details['quantity']) {
                    throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi.');
                }

                $order->items()->create([
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $details['quantity']);
            }

            // 3. Jika semua langkah berhasil, simpan permanen ke database
            DB::commit();

            // 4. Kosongkan session keranjang setelah berhasil checkout
            session()->forget('cart');

            // 5. Redirect ke halaman invoice dengan pesan sukses
            return redirect()->route('checkout.invoice', $order->id)->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');

        } catch (\Exception $e) {
            // 6. Jika ada satu saja error, batalkan semua query yang sudah dijalankan
            DB::rollBack();

            // Redirect kembali ke keranjang dengan pesan error
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
 * Menampilkan halaman invoice untuk pesanan tertentu.
 */
public function invoice(Order $order)
{
    // Baris keamanan: Pastikan user yang login hanya bisa melihat invoicenya sendiri
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses ke invoice ini.');
    }

    // Kirim data order ke view invoice.show
    return view('invoice.show', [
        'order' => $order
    ]);
}
}
