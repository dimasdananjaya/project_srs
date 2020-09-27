@extends('layouts.app')

@section('content')
<section id="store-list">
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/store.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Teges</b></h4>
                        <a href="#" class="btn btn-block">Show</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
    
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/store.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Retail</b></h4>
                        <a href="#" class="btn btn-block">Show</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
    
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/store.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Wholesale</b></h4>
                        <a href="#" class="btn btn-block">Show</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
        </div><!--row-->
    </div><!--container-->
</section>   
@endsection