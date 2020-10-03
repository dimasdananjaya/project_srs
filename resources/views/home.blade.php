@extends('layouts.app')

@section('content')
<section id="home">
    <div class="text-center banner">
        <h4>Halo <b>{{ Auth::user()->name }}</b></h4>
        <p>Silahkan pilih menu yang tersedia</p>
    </div><!--col-lg-12-->
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/sales.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Penjualan Toko</b></h4>
                        <p class="text-center">Kelola Data Penjualan Toko</p>
                        <a href="/toko-list" class="btn btn-block">Show</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
    
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/inventory.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Manajemen Barang</b></h4>
                        <p class="text-center">Kelola data Barang</p>
                        <a href="/barang" class="btn btn-block">Show</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
    
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/user.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Manajemen Pengguna</b></h4>
                        <p class="text-center">Kelola data Pengguna dan Member</p>
                        <a href="/member" class="btn btn-block">Show</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
        </div><!--row-->
    </div><!--container-->
</section>
@endsection
