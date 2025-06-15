<h1>Detail Order: {{ $order->order_code }}</h1>

<p>Status: {{ $order->status }}</p>
<p>Total: Rp{{ number_format($order->total_price) }}</p>

<ul>
    @foreach($order->items as $item)
        <li>
            {{ $item->product->name }} - {{ $item->quantity }} pcs - Rp{{ number_format($item->price) }}
            <br>
            @if($item->product->image)
                <img src="data:image/png;base64,{{ base64_encode($item->product->image) }}" width="100">
            @endif
        </li>
    @endforeach
</ul>
