<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::
        orderByDesc('sales')
            ->take(5)
            ->get();
        $newProducts = Product::latest()->take(5)->get();
        $newProducts = Product::latest()->take(5)->get();

        return view('home', compact('featuredProducts', 'newProducts'));
    }
}
