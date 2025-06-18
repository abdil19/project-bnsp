<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() // <--- INI PEMBUNGKUS YANG TADI HILANG
    {
        // 1. Ambil semua data produk dari database, urutkan dari yang terbaru
        $products = Product::latest()->paginate(8); // kita batasi 8 produk per halaman

        // 2. Kirim data tersebut ke sebuah view bernama 'index' di dalam folder 'products'
        return view('products.index', [
            'products' => $products
        ]);
    } // <--- DAN INI PENUTUPNYA
}
