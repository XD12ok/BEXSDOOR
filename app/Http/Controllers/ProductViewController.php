<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductViewController extends Controller
{
    public function increment($id)
    {
        $product = Product::findOrFail($id);

        if(auth()->check()){
        $viewed = session()->get('viewed_products', []);

        // Jika produk belum pernah dilihat oleh user ini di sesi ini
        if (!in_array($product->id, $viewed)) {
            $product->increment('views');

            // Simpan ke session
            $viewed[] = $product->id;
            session()->put('viewed_products', $viewed);
        }
    }

    }
}
