@extends('layouts.app')

@section('content')
<section id="toko-list">
    <div class="container mt-3">
        <h2 class="text-center"><b>Daftar Toko<b></h2>
        <hr>
        <div class="row mt-3">
            @foreach ($dataToko as $dt)
            <div class="col-lg-4">
                <div class="card">
                    <img class="card-img-top mx-auto d-block mb-2" src="/resources/logo/store.svg" alt="Card image cap">
                    <div class="card-body">
                        <h4 class="card-title text-center"><b>{{$dt->nama_toko}}</b></h4>
                        <hr>
                        <a href="#" class="btn btn-block btn-success" data-toggle="modal" data-target="#salesModal{{$dt->id_toko}}">Kelola Sales</a>
                        <a href="#" class="btn btn-block btn-success" data-toggle="modal" data-target="#reportModal">Rekap Laporan</a>
                    </div><!--card-body-->
                </div><!--card-->

                <!-- Sales modal -->
                <div class="modal fade" id="salesModal{{$dt->id_toko}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pilih Periode Sales</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div><!--modal-header-->
                            <div class="modal-body">
                                <div class="form-group-row">
                                    {!!Form::open(['route'=>['toko.dashboard', ''], 'method'=>'GET'])!!}
                                        <div class="col-lg-12">
                                            {{Form::label('periode','Periode :')}}
                                            <select class="form-control form-group" id="exampleFormControlSelect1" name="periode">
                                                @foreach ($dataPeriode as $dtp)
                                                    <option value="{{$dtp->id_periode}}">{{$dtp->periode}}</option>
                                                @endforeach
                                            </select>
                                            {{Form::hidden('id_toko',$dt->id_toko)}}
                                            {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                                        </div><!--col-lg-12-->
                                    {!!Form::close()!!}
                                </div><!--row-->
                            </div><!--modal-body-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div><!--modal-footer-->
                        </div><!--modal-content-->
                    </div><!--modal dialog-->
                </div><!--modal report-->

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
                                    {{ Form::open(['route' => 'toko.cek-toko', 'method'=>'GET']) }}
                                        <div class="col-lg-12">
                                            {{Form::label('dari','Dari :')}}
                                            {{Form::date('dari','',['class'=>'form-control form-group','placeholder'=>'dd/mm/yyyy','required'])}}
                                        </div><!--col-lg-6-->

                                        <div class="col-lg-12">
                                            {{Form::label('hingga','Hingga :')}}
                                            {{Form::date('hingga','',['class'=>'form-control form-group','placeholder'=>'dd/mm/yyyy','required'])}}
                                        </div><!--col-lg-6-->
                                        {{Form::hidden('id_toko',$dt->id_toko)}}
                                        {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                                    {!!Form::close()!!}
                                </div><!--row-->
                            </div><!--modal-body-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div><!--modal-footer-->
                        </div><!--modal-content-->
                    </div><!--modal dialog-->
                </div><!--modal report-->
            </div><!--col-lg-4-->
            @endforeach
        </div><!--row-->
    </div><!--container-->
</section>   
@endsection