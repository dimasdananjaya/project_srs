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
                        <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="home" aria-selected="true">Sales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="bon-tab" data-toggle="tab" href="#bon" role="tab" aria-controls="profile" aria-selected="false">Bon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="items-sold-tab" data-toggle="tab" href="#items-sold" role="tab" aria-controls="contact" aria-selected="false">Items Sold</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="myTabContent">

                    <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="sales-tab">
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
                                        <form id="formPenjualan" action="{{ route('penjualan.store') }}"  method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Tanggal :</label>
                                                    {{ Form::date('tanggal','',['class' => 'form-control form-group','required'],)}}
                                                </div><!--col-lg-6-->
                                                <div class="col-lg-6">
                                                    <label>Pembeli :</label>
                                                    {{ Form::text('nama_pembeli','',['class' => 'form-control form-group','required'],)}}
                                                </div><!--col-lg-6-->
                                                <div class="col-lg-6">
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
                                                </div><!--col-lg-6-->
                                                <div class="col-lg-6">
                                                    <label>Bank (Hanya Untuk Transfer):</label>
                                                    <select name="id_bank" class="form-control form-group">
                                                        <option value="5">
                                                            -
                                                        </option>
                                                        @foreach ($dataBank as $db)
                                                        <option value="{{$db->id_bank}}"">
                                                            {{$db->nama_bank}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div><!--col-lg-6-->
                                                <div class="col-lg-6">
                                                    <label>No Bon (Hanya Untuk Bon) :</label>
                                                    {{ Form::text('no_bon','',['class' => 'form-control form-group',])}}
                                                </div><!--col-lg-6-->
                                                <div class="col-lg-6">
                                                    <label>Keterangan :</label>
                                                    {{ Form::text('keterangan','',['class' => 'form-control form-group','required'])}}
                                                </div><!--col-lg-6-->
                                            </div><!--row-->

                                            {{Form::hidden('id_user', Auth::user()->id_user) }}
                                            @foreach ($dataToko as $dt) 
                                                <input type="hidden" id="id_toko" name="id_toko" value="{{$dt->id_toko}}">
                                            @endforeach
                                          
                                            {{Form::hidden('id_periode', $periode) }}
                                        
                                            <div class="card">
                                                <div class="card-header">
                                                    Products
                                                </div><!--card-header-->
                                                <div class="card-body">
                                                    <table id="tabel_barangs" class="table table-bordered table-responsive">
                                                        <tr>
                                                            <th><input class='check_all' type='checkbox' onclick="select_all()"/></th>
                                                            <th>No.</th>
                                                            <th>Jumlah</th>
                                                            <th>Id Barang</th>
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
                                                            <td><input style="width:6em;" class="form-control autocomplete_txt" type='text' data-type="id_barang" id='id_barang_1' name='id_barang[]' readonly/></td>
                                                            <td><input style="width:15em;" class="form-control autocomplete_txt" type='text' data-type="nama_barang" id='nama_barang_1' name='nama_barang[]'/></td>
                                                            <td><input class="form-control autocomplete_txt uang" type='text' data-type="harga_pokok" id='harga_pokok_1' name='harga_pokok[]'readonly/> </td>
                                                            <td><input class="form-control autocomplete_txt uang" type='text' data-type="harga_jual" id='harga_jual_1' name='harga_jual[]' readonly/> </td>
                                                            <td><input class="form-control autocomplete_txt uang" type='text' data-type="total_harga_pokok" id='total_harga_pokok_1' name='total_harga_pokok[]' readonly/> </td>
                                                            <td><input class="form-control autocomplete_txt uang" type='text' data-type="total_harga_jual" id='total_harga_jual_1' name='total_harga_jual[]' readonly/> </td>                                                            
                                                         </tr>
                                                        </table>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <button type="button" class='btn btn-danger delete'>- Delete</button>
                                                            <button type="button" class='btn btn-success addbtn'>+ Add More</button>
                                                        </div><!--col-12-->
                                                        <div class="col-md-6 offset-md-6">
                                                            <label class="mt-3">Diskon :</label>
                                                            <input class="form-control uang" min="0" type='text' value="0" id='diskon' name='diskon'/>
                                                            <hr>
                                                            <label class="mt-3">Total Harga Pokok Penjualan:</label>
                                                            <input type="text" class="form-control uang" id="total_harga_pokok_akhir" name="total_harga_akhir_pokok_penjualan" readonly>
                                                            <label class="mt-3">Total Harga Jual Penjualan:</label>
                                                            <input type="text" class="form-control uang" id="total_akhir1" name="total_harga_akhir_jual_penjualan" readonly>
                                                            <label class="mt-3"><b>Total Akhir Setelah Diskon:</b></label>
                                                            <input class="form-control uang" type='text' id='total_akhir2' name='total_akhir' readonly/>
                                                            <a style="color: #ffffff;" class="btn btn-info hitungAll mt-3 btn-block">Hitung Total</a>
                                                            <!--<a style="color: #ffffff;" class="btn btn-info resetTotal mt-3 btn-block">Reset Total</a>-->
                                                        </div><!--col -3-->
                                                    </div><!--row-->
                                                </div><!--card-body-->
                                            </div><!--card-->
                                            <input class="btn btn-primary btn-block" type="submit">
                                        </form>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!--end modal body-->
                                </div><!-- end modal content-->
                            </div><!--end modal dialog-->
                        </div><!--end modal-->
                        <table class="table table-hover table-bordered dt-responsive table-responsive-xl table-sm" id="example" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tanggal</th>
                                    <th>Pembeli</th>
                                    <th>Items</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Bank</th>
                                    <th>Total Harga Pokok</th>
                                    <th>Total Harga Jual</th>
                                    <th>Total Diskon</th>
                                    <th>Total Akhir</th>
                                    <th>Keuntungan</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataPenjualanLunas as $dp)
                                <tr>
                                    <td>{{$dp->id_penjualan}}</td>
                                    <td>{{$dp->tanggal}}</td>
                                    <td>{{$dp->nama_pembeli}}</td>
                                    <td>
                                        <?php
                                            $barangs= DB::table('barang_penjualan')
                                            ->join('barang', 'barang_penjualan.id_barang', '=', 'barang.id_barang')
                                            ->select('barang_penjualan.*', 'barang.nama_barang')
                                            ->where('id_penjualan',$dp->id_penjualan)
                                            ->get();

                                            $hargaJual=$dp->total_harga_jual;
                                            $hargaPokok=$dp->total_harga_pokok;
                                            $diskon=$dp->diskon;

                                            $keuntungan=$hargaJual-$hargaPokok-$diskon;
                                        ?>
                                        @foreach ($barangs as $barang)
                                            <p><small>{{$barang->nama_barang}} x ({{$barang->jumlah}})</small></p>
                                        @endforeach
                                    </td>
                                    <td>{{$dp->jenis_pembayaran}}</td>
                                    <td>{{$dp->nama_bank}}</td>
                                    <td>{{ number_format($dp->total_harga_pokok, 2, ',', '.') }}</td>
                                    <td>{{ number_format($dp->total_harga_jual, 2, ',', '.') }}</td>
                                    <td>{{ number_format($dp->diskon, 2, ',', '.') }}</td>
                                    <td>{{ number_format($dp->total_akhir, 2, ',', '.') }}</td>
                                    <td>{{ number_format($keuntungan, 2, ',', '.') }}</td>
                                    <td>{{$dp->keterangan}}</td>
                                    <td><b>{{$dp->status}}</b></td>
                                    <td>
                                        <!-- Modal Hapus Penjualan -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-penjualan{{$dp->id_penjualan}}">
                                            Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-hapus-penjualan{{$dp->id_penjualan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!!Form::open(['route'=>['penjualan.destroy', $dp->id_penjualan], 'method'=>'POST'])!!}
                                                            <h3>Hapus Penjualan Id : {{$dp->id_penjualan}}?</h3>
                                                            {{Form::hidden('_method', 'DELETE')}}                                                
                                                            {{Form::submit('Hapus Penjualan Ini?',['class'=>'btn btn-danger'])}}
                                                        {!!Form::close()!!}
                                                    </div>
                                                </div><!--modal-content-->
                                            </div><!--modal dialog-->
                                        </div><!-- modal fade-->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!--tab tambah penjualan-->

<!---------------------------------------------------------- tab bon--------------------------------------------------->
                    <div class="tab-pane fade" id="bon" role="tabpanel" aria-labelledby="bon-tab">
                        <!-- Button Tambah Penjualan modal -->
                        <h3><b>Tabel Bon</b></h3>
                        <hr>
                        <table class="table table-hover table-bordered dt-responsive table-responsive-xl table-sm" id="tabel-bon" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No. Bon</th>
                                    <th>Pembeli</th>
                                    <th>Items</th>
                                    <th>Jenis Pembayaran</th>
                                    <th>Total Harga Pokok</th>
                                    <th>Total Harga Jual</th>
                                    <th>Total Diskon</th>
                                    <th>Total Akhir</th>
                                    <th>Total Bayar</th>
                                    <th>Sisa</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach($dataPenjualanBon as $dpb)
                                    <tr>
                                        <td>{{$dpb->tanggal}}</td>
                                        <td>{{$dpb->no_bon}}</td>
                                        <td>{{$dpb->nama_pembeli}}</td>
                                        <td>
                                            <?php
                                                $barangs= DB::table('barang_penjualan')
                                                ->join('barang', 'barang_penjualan.id_barang', '=', 'barang.id_barang')
                                                ->select('barang_penjualan.*', 'barang.nama_barang')
                                                ->where('id_penjualan',$dpb->id_penjualan)
                                                ->get();
                                            ?>
                                            @foreach ($barangs as $barang)
                                                <p><small>{{$barang->nama_barang}} x ({{$barang->jumlah}})</small></p>
                                            @endforeach
                                        </td>
                                        <td>{{$dpb->jenis_pembayaran}}</td>
                                        <td> {{ number_format($dpb->total_harga_pokok, 2) }}</td>
                                        <td> {{ number_format($dpb->total_harga_jual, 2) }}</td>
                                        <td> {{ number_format($dpb->diskon, 2) }}</td>
                                        <td> {{ number_format($dpb->total_akhir, 2) }}</td>
                                        <td>
                                            @php
                                            $id_bon=$dpb->id_penjualan;
                                            $totalBayar=DB::select(DB::raw("SELECT sum(jumlah_pembayaran) AS total_bayar FROM pembayaran_bon WHERE id_penjualan=$id_bon GROUP BY id_penjualan"));
                                            @endphp
                                            @foreach ($totalBayar as $tb)
                                                {{ number_format($tb->total_bayar, 2) }}
                                            @endforeach     
                                        </td>
                                        <td>
                                            @php
                                                if ($totalBayar==null) {
                                                    echo number_format("0",2);
                                                }
                                                else {
                                                    //cari sisa pembayaran
                                                    foreach ($totalBayar as $tb) {
                                                        $x=$dpb->total_akhir;
                                                        $y=$tb->total_bayar;
                                                        $sisa=$x-$y;
                                                        echo number_format("$sisa",2);
                                                    }
                                                }
                                            @endphp
                                        </td>
                                        <td>{{$dpb->keterangan}}</td>
                                        <td>
                                            @php
                                            if ($totalBayar==null){
                                                echo "Belum Lunas";
                                            }
                                             elseif ($sisa==0) {
                                                 echo "Lunas";
                                             }
                                             elseif ($y>$x) {
                                                 echo "Melebihi Pembayaran";
                                             }
                                             else {
                                                 echo "Belum Lunas";
                                             }   
                                            @endphp
                                        </td>
                                        <td>
                                            <!-- Modal Hapus Bon -->
                                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-bon{{$dpb->id_penjualan}}">
                                                Hapus
                                            </button>
    
                                            <!-- Modal -->
                                            <div class="modal fade" id="modal-hapus-bon{{$dpb->id_penjualan}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {!!Form::open(['route'=>['hapus.penjualan-bon', $dpb->id_penjualan], 'method'=>'DELETE'])!!}
                                                                <h4>Hapus Penjualan Bon Id : {{$dpb->id_penjualan}}?</h4>
                                                                {{Form::hidden('_method', 'DELETE')}}                                                
                                                                {{Form::submit('Hapus Penjualan Ini?',['class'=>'btn btn-danger'])}}
                                                            {!!Form::close()!!}
                                                        </div>
                                                    </div><!--modal-content-->
                                                </div><!--modal dialog-->
                                            </div><!-- modal fade-->
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>

                        <h3 class="mt-5"><b>Pembayaran Bon</b></h3>
                        <hr>
                        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#tambah-pembayaran-bon-modal">
                            Tambah Pembayaran Bon
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="tambah-pembayaran-bon-modal" tabindex="-1" role="dialog"  aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran Bon</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="formPembayaranBon" action="{{ route('tambah.pembayaran-bon') }}"  method="POST">
                                            @csrf
                                            <label>Pilih Bon :</label>
                                            <select name="id_penjualan" class="form-control form-group">
                                                <option value="">-- pilih --</option>
                                                @foreach ($dataPenjualanBon as $dpb)
                                                    <option value="{{ $dpb->id_penjualan }}">
                                                        {{ $dpb->no_bon }} - {{$dpb->nama_pembeli}} - {{$dpb->tanggal}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label>Metode Pembayaran :</label>
                                            <select name="metode_pembayaran" class="form-control form-group">
                                                <option value="cash">
                                                    Cash
                                                </option>
                                                <option value="transfer">
                                                    Transfer
                                                </option>
                                            </select>

                                            <label>Bank (Hanya Untuk Transfer):</label>
                                            <select name="id_bank" class="form-control form-group">
                                                <option value="5">
                                                    -
                                                </option>
                                                @foreach ($dataBank as $db)
                                                <option value="{{$db->id_bank}}">
                                                    {{$db->nama_bank}}
                                                </option>
                                                @endforeach
                                            </select>

                                            <label>Jumlah Pembayaran :</label>
                                            {{ Form::text('jumlah_pembayaran','',['class' => 'form-control form-group uangPembayaranBon','required'])}}
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Tanggal :</label>
                                                    {{ Form::date('tanggal','',['class' => 'form-control form-group'])}}
                                                </div><!--col-lg-6-->
                                                <div class="col-lg-6">
                                                    <label>Referral :</label>
                                                    {{ Form::text('referral','',['class' => 'form-control form-group','required'])}}
                                                </div><!--col-lg-6-->
                                            </div><!--row-->

                                            @foreach ($dataToko as $dt) 
                                            {{Form::hidden('id_toko', $dt->id_toko) }}
                                            @endforeach
                                            {{Form::hidden('id_periode', $periode) }}
                                            <input class="btn btn-primary btn-block" type="submit">
                                        </form>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div><!--end modal body-->
                                </div><!-- end modal content-->
                            </div><!--end modal dialog-->
                        </div><!--end modal-->
                        <table class="table table-striped table-bordered dt-responsive nowrap mt-3" id="tabel-pembayaran-bon">
                            <thead>
                                <tr>
                                    <th>No Bon</th>
                                    <th>Tanggal</th>
                                    <th>Nama Pembeli</th>
                                    <th>Jumlah Pembayaran</th>
                                    <th>Referral</th>                                   
                                    <th>Metode Pembayaran</th>
                                    <th>Nama Bank</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataPembayaranBon as $dpb)
                                <tr>
                                    <td>{{$dpb->no_bon}}</td>
                                    <td>{{$dpb->tanggal}}</td>
                                    <td>{{$dpb->nama_pembeli}}</td>
                                    <td>{{ number_format($dpb->jumlah_pembayaran, 2) }}</td>
                                    <td>{{$dpb->metode_pembayaran}}</td>
                                    <td>{{$dpb->referral}}</td>                                  
                                    <td>{{$dpb->nama_bank}}</td>
                                    <td>
                                        <!-- Modal Hapus Pembayaran Bon -->
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#modal-hapus-pembayaran-bon{{$dpb->id_pembayaran_bon}}">
                                            Hapus
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="modal-hapus-pembayaran-bon{{$dpb->id_pembayaran_bon}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {!!Form::open(['route'=>['hapus.pembayaran-bon', $dpb->id_pembayaran_bon], 'method'=>'DELETE'])!!}
                                                            <h4>Hapus Pembayaran Bon Id : {{$dpb->id_pembayaran_bon}}?</h4>
                                                            {{Form::hidden('_method', 'DELETE')}}                                                
                                                            {{Form::submit('Hapus Penjualan Ini?',['class'=>'btn btn-danger'])}}
                                                        {!!Form::close()!!}
                                                    </div>
                                                </div><!--modal-content-->
                                            </div><!--modal dialog-->
                                        </div><!-- modal fade-->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div><!--tab bon-->


                    <div class="tab-pane fade" id="items-sold" role="tabpanel" aria-labelledby="items-sold-tab">
                        <div class="card">
                            <div class="card-header">
                                <h3><b>Total Barang Terjual</b></h3>
                            </div><!--card-header-->
                            <div class="card-body">
                                <table id="tabel-penjualan-barang" class="table table-stripped table-bordered table-responsive-sm table-responsive-lg">
                                    <thead>
                                        <th>Id Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Terjual</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataTotalBarangTerjual as $dtbt)
                                        <tr>
                                            <td>{{$dtbt->id_barang}}</td>
                                            <td>{{$dtbt->nama_barang}}</td>
                                            <td>{{$dtbt->jumlah_barang_terjual}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div><!--card-body-->
                        </div><!--card-->
                    </div><!--tab items sold-->

            </div><!--card-body-->
        </div><!--card-->
    </div><!--container-->
</section>


@endsection