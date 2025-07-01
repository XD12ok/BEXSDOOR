@foreach($products as $product)
    <x-product-card :product="$product" />
@endforeach
