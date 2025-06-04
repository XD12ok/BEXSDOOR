@extends('layouts.adminApp')

@section('content')

<h1>ADMIN MENU</h1>
<a href="/BEXSDOOR Home">BEXSDOOR</a>
<br>
<a href="#">Admin Panel</a>
<br>
<a href="/products/create">tambah produk</a>
<br>
<a href="/orders">Pesanan</a>
<?php
function admin()
{
    echo "halo Admin";
    echo "<a href='/logout'>Logout>></a>";

}
?>
<br>

<a href='/logout'>Logout>></a>

@endsection
