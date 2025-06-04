<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'categories' => 'required|in:Nata Series,Yaza Series,Hogma Series,PVC,Glass',
            'image' => 'nullable|image|max:5120', // Maks 5MB
            'description' => 'nullable|string|max:10000',
            'SKU' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
        ]);


        $imageData = null;
        if ($request->hasFile('image')) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
        }

        Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'categories' => $validated['categories'],
            'image' => $imageData,
            'description' => $validated['description'],
            'color' => $validated['color'],
            'SKU' => $validated['SKU'],
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Ambil array session
        $viewed = session()->get('viewed_products', []);

        // Pakai strict + casting
        if (!in_array((int) $id, $viewed, true)) {
            $product->increment('views');

            $viewed[] = (int) $id;
            session()->put('viewed_products', $viewed);
            session()->save();
        }

        $featuredProducts = Product::
            orderByDesc('sales')
            ->take(5)
            ->get();
        $newProducts = Product::latest()->take(5)->get();

        Product::where('id', $id)->increment('views');

        // Kirim variabel ke view
        return view('products.show', compact('product', 'featuredProducts', 'newProducts' ));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id); // Mencari produk berdasarkan ID
        return view('products.edit', compact('product')); // Mengirim data produk ke form edit
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'categories' => 'required|in:Nata Series,Yaza Series,Hogma Series,PVC,Glass',
            'image' => 'nullable|image|max:5120',
            'description' => "nullable|string|max:255",
            'color'=> 'nullable|string|max:255',
            'SKU' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($id); // Mencari produk berdasarkan ID

        // Jika ada gambar baru, simpan gambar
        if ($request->hasFile('image')) {
            $imageData = file_get_contents($request->file('image')->getRealPath());
            $product->image = $imageData; // Update gambar
        }

        // Update data produk
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->categories = $validated['categories'];
        $product->description = $validated['description'];
        $product->color = $validated['color'];
        $product->SKU = $validated['SKU'];
        $product->save();

        return redirect()->route('products.show', $product->id)->with('success', 'Produk berhasil diperbarui!');
    }

    public function index(Request $request)
    {
            $queryBuilder = Product::query();

            // Pencarian berdasarkan nama produk
            if ($request->filled('search')) {
                $queryBuilder->where('name', 'LIKE', '%' . $request->search . '%');
            }

        if ($request->filled('categories')) {
            $queryBuilder->where('categories', $request->categories);
        }

        // Filter harga minimum
        if ($request->filled('price_min')) {
            $queryBuilder->where('price', '>=', $request->price_min);
        }

        // Filter harga maksimum
        if ($request->filled('price_max')) {
            $queryBuilder->where('price', '<=', $request->price_max);
        }

            // Filter sorting
            if ($request->filled('sort')) {
                switch ($request->sort) {
                    case 'populer':
                        $queryBuilder->orderByDesc('views');
                        break;
                    case 'terlaris':
                        $queryBuilder->orderByDesc('sales');
                        break;
                    case 'terbaru':
                        $queryBuilder->orderByDesc('created_at');
                        break;
                }
            }

            // Ambil hasil akhir
            $products = $queryBuilder->paginate(9)->withQueryString();

            return view('products.index', compact('products'));
        }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus.');
    }

    public function paginate(Request $request)
    {
        $products = Product::paginate(10);

        foreach ($products as $product) {
            $product->image_url = 'data:image/jpeg;base64,' . base64_encode($product->image);
        }


        if ($request->ajax()) {
            return view('admin.products.partials.table', compact('products'))->render();
        }

        return view('Admin.InfoProduk', compact('products'));
    }


}
