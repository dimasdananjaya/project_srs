@extends('layouts.app')

@section('content')
<section id="store-dashboard">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
            <h4>Dashboard Toko : <b> @foreach ($dataToko as $dt) {{$dt->nama_toko}} @endforeach</b></h4>
            </div><!--card-header-->
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="home" aria-selected="true">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#bon" role="tab" aria-controls="profile" aria-selected="false">Bon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#items-sold" role="tab" aria-controls="contact" aria-selected="false">Items Sold</a>
                </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">

                    <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="home-tab">
                        <!-- Button Tambah Penjualan modal -->
                        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#add-orders-modal">
                            Tambah Penjualan
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="add-orders-modal" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penjualan</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('barang.store') }}"  method="POST">
                                            @csrf
                                            <label>Pembeli / Member :</label>
                                            <select name="id_member" class="form-control form-group">
                                                <option value="">-- pilih --</option>
                                                @foreach ($dataMember as $dm)
                                                    <option value="{{ $dm->id_member }}">
                                                        {{ $dm->nama_member }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label>Metode Pembayaran :</label>
                                            <select name="jenis_pembayaran" class="form-control form-group">
                                                <option value="cash">
                                                    Cash
                                                </option>
                                                <option value="transfer">
                                                    Transfer
                                                </option>
                                                <option value="bon">
                                                    Bon
                                                </option>
                                            </select>
                                            <label>Keterangan :</label>
                                            {{ Form::text('keterangan','',['class' => 'form-control form-group'])}}
                                            {{Form::hidden('id_user', Auth::user()->id_user) }}
                                            @foreach ($dataToko as $dt) 
                                                {{Form::hidden('id_toko', $dt->id_toko) }}
                                            @endforeach
                                            @foreach ($dataPeriode as $dp) 
                                                {{Form::hidden('id_periode', $dp->id_periode) }}
                                            @endforeach
                                            {{-- ... customer name and email fields --}}
                                        
                                            <div class="card">
                                                <div class="card-header">
                                                    Products
                                                </div>

                                                <div class="card-body">
                                                    <table id="tabel_barangs" class="table table-bordered table-responsive">
                                                        <tr>
                                                            <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                                            <th>No.</th>
                                                            <th>Jumlah</th>
                                                            <th>Nama Barang</th>
                                                            <th>Harga Pokok</th>
                                                            <th>Harga Jual</th>
                                                            <th>Total Harga Pokok</th>
                                                            <th>Total Harga Jual</th>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <td><input type='checkbox' class='chkbox'/></td>
                                                            <td><span id='sn'>1.</span></td>
                                                            <td><input style="width:6em;" class="form-control" type='number' data-type="jumlah" id='jumlah_1' name='jumlah[]'/> </td>
                                                            <td><input style="width:15em;" class="form-control span-2 autocomplete_txt" type='text' data-type="nama_barang" id='nama_barang_1' name='nama_barang[]'/></td>
                                                            <td><input class="form-control autocomplete_txt" type='number' data-type="harga_pokok" id='harga_pokok_1' name='harga_pokok[]'readonly/> </td>
                                                            <td><input class="form-control autocomplete_txt" type='number' data-type="harga_jual" id='harga_jual_1' name='harga_jual[]' readonly/> </td>
                                                            <td><input class="form-control autocomplete_txt" type='number' data-type="total_harga_pokok" id='total_harga_pokok_1' name='total_harga_pokok[]' readonly/> </td>
                                                            <td><input class="form-control autocomplete_txt" type='number' data-type="total_harga_jual" id='total_harga_jual_1' name='total_harga_jual[]' readonly/> </td>
                                                            
                                                          </tr>
                                                        </table>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class='btn btn-danger delete'>- Delete</button>
                                                            <button type="button" class='btn btn-success addbtn'>+ Add More</button>
                                                        </div><!--col-12-->
                                                        <div class="col-md-6 offset-md-6">
                                                            <label class="mt-3">Diskon :</label>
                                                            <input class="form-control" type='number' id='diskon' name='diskon'/>
                                                            <hr>
                                                            <label class="mt-3">Total Akhir:</label>
                                                            <input class="form-control" type='number' id='total_akhir' name='total_akhir' readonly/>
                                                        </div><!--col -3-->
                                                    </div><!--row-->
                                                </div><!--card-body-->
                                            </div><!--card-->

                                            <div>
                                                <input class="btn btn-primary btn-block" type="submit">
                                            </div>
                                        </form>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!--end modal body-->
                                </div><!-- end modal content-->
                            </div><!--end modal dialog-->
                        </div><!--end modal-->
                        <table class="table table-striped table-bordered dt-responsive nowrap" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Pembeli</th>
                                    <th>Items</th>
                                    <th>Total Harga Pokok</th>
                                    <th>Total Harga Jual</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Dims</td>
                                    <td>System Architect</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    <td>$320,800</td>
                                    <td>5421</td>
                                </tr>

                            </tbody>
                        </table>
                    </div><!--tab tambah penjualan-->
                    <div class="tab-pane fade" id="bon" role="tabpanel" aria-labelledby="profile-tab">

                    </div><!--tab bon-->
                    <div class="tab-pane fade" id="items-sold" role="tabpanel" aria-labelledby="contact-tab">

                    </div><!--tab items sold-->
                </div><!--tab content-->
            </div><!--card-body-->
        </div><!--card-->
    </div><!--container-->
</section>


@endsection