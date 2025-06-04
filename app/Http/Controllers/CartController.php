<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::where('user_id', auth()->id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request, $productId)
    {
        $item = CartItem::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $productId],
            ['quantity' => 0]
        );

        $item->increment('quantity', $request->input('quantity', 1));

        if ($request->has('buy')) {
            return redirect()->route('cart.index')->with('success', 'Produk ditambahkan dan siap dibeli.');
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }


    public function remove($id)
    {
        CartItem::where('id', $id)->where('user_id', auth()->id())->delete();
        return back()->with('success', 'Produk dihapus dari keranjang');
    }

    public function viewCart()
    {
        $userId = auth()->id();

        $cartItems = CartItem::with('product')
            ->where('user_id', $userId)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function update(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        if ($request->has('increment')) {
            $cartItem->quantity += 1;
        } elseif ($request->has('decrement') && $cartItem->quantity > 1) {
            $cartItem->quantity -= 1;
        }
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = CartItem::findOrFail($id);
        if ($request->increment) {
            $cartItem->quantity++;
        } elseif ($request->decrement && $cartItem->quantity > 1) {
            $cartItem->quantity--;
        }
        $cartItem->save();

        $itemSubtotal = $cartItem->quantity * $cartItem->product->price;

        // Kembalikan JSON response
        return response()->json([
            'success' => true,
            'quantity' => $cartItem->quantity,
            'itemSubtotal' => $itemSubtotal,
            'price' => $cartItem->product->price,
            // bisa tambah subtotal per item atau total cart juga jika mau
        ]);
    }


}
