@extends('layouts.app')

@section('content')
<section id="manage-member">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4><b>Kelola Data Member</b></h4>
            </div><!--card-header-->
            <div class="card-body">

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success mb-3"  data-toggle="modal" data-target="#memberModal">
                Tambah Member
            </button>
            
            <!-- Modal -->
            <div class="modal fade" id="memberModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><b>Tambah Data Member</b></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(['route' => 'member.store']) }}
                                {{Form::label('nama_member','Nama Member :')}}
                                {{Form::text('nama_member','',['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                {{Form::label('no_kontak','No. Kontak :')}}
                                {{Form::number('no_kontak','',['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                {{Form::submit('Simpan',['class'=>'btn btn-success btn-block'])}}
                            {{ Form::close() }}
                        </div>
                    </div><!--modal-content-->
                </div><!--modal-dialog-->
            </div><!--modal-fade-->

                <table id="tabel-barang" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <th>No.</th>
                        <th>Nama Member</th>
                        <th>No. Kontak</th>
                        <th>Tanggal Join</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($dataMember as $dm)
                            <tr>
                                <td></td>
                                <td>{{$dm->nama_member}}</td>
                                <td>{{$dm->no_kontak}}</td>
                                <td>{{$dm->created_at}}</td>
                                <td><a class="btn btn-success" style="color:#fff;" data-toggle="modal" data-target="#edit-member-modal{{$dm->id_member}}">Edit</a></td>
                            </tr>
                            <!-- Modal Edit Tagihan Pembayaran-->
                            <div class="modal fade" id="edit-member-modal{{$dm->id_member}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2>Form Edit Member</h2>   
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                        {!!Form::open(['route'=>['member.update', $dm->id_member], 'method'=>'PUT'])!!}
                                            {{Form::label('nama_member','Nama Member :')}}
                                            {{Form::text('nama_member',$dm->nama_member,['class'=>'form-control form-group','placeholder'=>'','required'])}}
                                            {{Form::label('no_kontak','No. kontak :')}}
                                            {{Form::number('no_kontak',$dm->no_kontak,['class'=>'form-control form-group','placeholder'=>'','required'])}}
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

<script type="text/javascript">
    $(document).ready(function() {
        var t = $('#tabel-barang').DataTable( {
            "columnDefs": [ {
                "searchable": false,
                "orderable": false,
                "targets": 0
            } ],
            "order": [[ 1, 'asc' ]],
            "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
        }
        } );
    
        t.on( 'order.dt search.dt', function () {
            t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();        
    } );
</script>
@endsection