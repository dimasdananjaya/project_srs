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
                        <hr>
                        <button href="#" class="btn btn-block btn-primary">Kelola Sales</button>
                        <button href="#" class="btn btn-block btn-primary" data-toggle="modal" data-target="#reportModal">Rekap Laporan</button>
                    </div><!--card-body-->
                </div><!--card-->

                <!-- Report modal -->
                <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pilih Tanggal Laporan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div><!--modal-header-->
                            <div class="modal-body">
                                <div class="form-group-row">
                                    {!!Form::open(['action'=>'BarangController@store', 'method'=>'POST'])!!}
                                        <div class="col-lg-12">
                                            {{Form::label('dari','Dari :')}}
                                            {{Form::date('dari','',['class'=>'form-control form-group','placeholder'=>'dd/mm/yyyy','required'])}}
                                        </div><!--col-lg-6-->

                                        <div class="col-lg-12">
                                            {{Form::label('hingga','Hingga :')}}
                                            {{Form::date('hingga','',['class'=>'form-control form-group','placeholder'=>'dd/mm/yyyy','required'])}}
                                        </div><!--col-lg-6-->
                                        {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                                    {!!Form::close()!!}
                                </div><!--row-->
                            </div><!--modal-body-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Go</button>
                            </div><!--modal-footer-->
                        </div><!--modal-content-->
                    </div><!--modal dialog-->
                </div><!--modal report-->
            </div><!--col-lg-4-->
    
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/store.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Retail</b></h4>
                        <a href="#" class="btn btn-block">Show</a>
                        <a href="#" class="btn btn-block">Report</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
    
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/store.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>Wholesale</b></h4>
                        <a href="#" class="btn btn-block">Show</a>
                        <a href="#" class="btn btn-block">Report</a>
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--col-lg-4-->
        </div><!--row-->
    </div><!--container-->
</section>   
@endsection