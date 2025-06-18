<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cart = session('cart', []);
        return view('cart.index', ['cart' => $cart]);
    }

    /**
     * Menambahkan produk ke dalam keranjang.
     */
    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1, // Otomatis tambah 1
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', $product->name . ' berhasil ditambahkan ke keranjang!');
    }

        /**
     * Menghapus produk dari keranjang.
     */
    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            session()->flash('success', 'Produk berhasil dihapus dari keranjang.');
            return redirect()->route('cart.index');
        }

        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }
}
