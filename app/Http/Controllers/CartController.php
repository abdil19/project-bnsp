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
        $request->validate(['quantity' => 'required|numeric|min:1']);

        $cart = session()->get('cart', []);
        $quantity = (int)$request->input('quantity');

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', $quantity . ' ' . $product->name . ' berhasil ditambahkan!');
    }

    /**
     * Mengupdate jumlah produk di keranjang.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['quantity' => 'required|numeric|min:1']);
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int)$request->input('quantity');
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Jumlah produk berhasil diupdate.');
        }
        return redirect()->back()->with('error', 'Produk tidak ditemukan.');
    }

        /**
     * Menghapus produk dari keranjang.
     */
    public function remove($id) // <--- NAMA METHOD-NYA SUDAH BENAR
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
