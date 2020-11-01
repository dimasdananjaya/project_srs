@extends('layouts.app')

@section('content')
<section id="barang-dashboard">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4><b>Kelola Barang</b></h4>
            </div><!--card-header-->
            <div class="card-body">

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success mb-3"  data-toggle="modal" data-target="#exampleModal">
                Tambah Barang
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Tambah Data Barang</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(['route' => 'barang.store']) }}
                                {{Form::label('nama_barang','Nama Barang :')}}
                                {{Form::text('nama_barang','',['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                {{Form::label('harga_pokok','Harga Pokok :')}}
                                {{Form::number('harga_pokok','',['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                {{Form::label('harga_jual','Harga Jual :')}}
                                {{Form::number('harga_jual','',['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                {{Form::hidden('jenis', 'product') }}
                                {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                            {{ Form::close() }}
                        </div>
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal-fade-->

                <table id="tabel-barang" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <th>Toko</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($dataBarang as $db)
                            <tr>
                                <td>{{$db->nama_toko}}</td>
                                <td>{{$db->nama_barang}}</td>
                                <td>{{$db->jenis}}</td>
                                <td>{{ number_format($db->harga_pokok, 2) }}</td>
                                <td>{{ number_format($db->harga_jual, 2) }}</td>
                                <td><a class="btn btn-success" style="color:#fff;" data-toggle="modal" data-target="#edit-barang-modal{{$db->id_barang}}">Edit</a></td>
                            </tr>
                            <!-- Modal Edit Tagihan Pembayaran-->
                            <div class="modal fade" id="edit-barang-modal{{$db->id_barang}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2>Form Edit Barang</h2>   
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        {!!Form::open(['route'=>['barang.update', $db->id_barang], 'method'=>'PUT'])!!}
                                            {{Form::label('nama_barang','Nama Barang :')}}
                                            {{Form::text('nama_barang',$db->nama_barang,['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                            {{Form::label('harga_pokok','Harga Pokok :')}}
                                            {{Form::number('harga_pokok',$db->harga_pokok,['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                            {{Form::label('harga_jual','Harga Jual :')}}
                                            {{Form::number('harga_jual',$db->harga_jual,['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                            {{Form::hidden('jenis', 'barang') }}
                                            {{Form::hidden('id_toko', $db->id_toko) }}
                                            {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                                        {{ Form::close() }}
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Modal Edit Tagihan Pembayaran-->   
                        @endforeach
                    </tbody>
                </table>
            </div><!--card-body-->
        </div><!--card-->
    </div><!--container-->
</section>


@endsection