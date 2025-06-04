@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Products</h1>

        <div id="product-table">
            @include('Admin.InfoProduk')
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();

            let url = $(this).attr('href');

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    $('#product-table').html(data);
                },
                error: function() {
                    alert('Pagination failed.');
                }
            });
        });
    </script>
@endpush
