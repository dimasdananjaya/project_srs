@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3><b>Cek Toko : @foreach ($dataToko as $dt) {{$dt->nama_toko}} @endforeach</b></h3>
        </div><!--card-header-->

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="rekap-tab" data-toggle="tab" href="#rekap" role="tab" aria-controls="rekap" aria-selected="true">Rekap</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="barang-terjual-tab" data-toggle="tab" href="#barang-terjual" role="tab" aria-controls="barang-terjual" aria-selected="false">Barang Terjual</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pembayaran-bon-tab" data-toggle="tab" href="#pembayaran-bon" role="tab" aria-controls="pembayaran-bon" aria-selected="false">Pembayaran Bon</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="rekap" role="tabpanel" aria-labelledby="rekap-tab">
                <div class="card-body">
                    <table id="tabel-cek-toko" class="table table-stripped table-bordered">
                        <thead>
                            <th>Tanggal</th>
                            <th>Total Penjualan</th>
                            <th>Pokok</th>
                            <th>Untung</th>
                            <th>Tunai</th>
                            <th>Transfer</th>
                            <th>Bon</th>
                            <th>Total Bayar Bon</th>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < count($tanggal); $i++) 
                                <tr>
                                    <td>{{$tanggal[$i]}}</td>
                                    @php
                                        $cekToko=DB::select(DB::raw(" 
                                        select tanggal, sum(total_akhir) as total_penjualan, 
                                        sum(total_harga_pokok) as pokok from penjualan
                                        where id_toko = $idToko
                                        and tanggal = '$tanggal[$i]'"));
        
                                        $cash=DB::select(DB::raw(" 
                                        select sum(total_akhir) as cash from penjualan
                                        where jenis_pembayaran='cash'
                                        and id_toko = $idToko
                                        and tanggal = '$tanggal[$i]'"));
        
                                        $transfer=DB::select(DB::raw(" 
                                        select sum(total_akhir) as transfer from penjualan
                                        where jenis_pembayaran='transfer'
                                        and id_toko = $idToko
                                        and tanggal = '$tanggal[$i]'"));
        
                                        $bon=DB::select(DB::raw(" 
                                        select sum(total_akhir) as total_bon from penjualan                                                
                                        where jenis_pembayaran='bon' 
                                        and id_toko = $idToko
                                        and tanggal = '$tanggal[$i]'"));     
                                        
                                        $bayarBon=DB::select(DB::raw(" 
                                        select sum(jumlah_pembayaran) as total_bayar_bon from pembayaran_bon                                                
                                        where id_toko = $idToko
                                        and tanggal = '$tanggal[$i]'")); 
                                    @endphp
        
                                    @foreach ($cekToko as $ct)
                                        @php
                                            $x=$ct->total_penjualan;
                                            $y=$ct->pokok;
                                            
                                            $untung=$x-$y;
        
                                        @endphp
                                            <td> {{ number_format($ct->total_penjualan, 2) }}</td>
                                            <td> {{ number_format($ct->pokok, 2) }}</td>
                                            <td> {{ number_format($untung, 2) }}</td> 
                                        @foreach ($cash as $cash)
                                            <td> {{ number_format($cash->cash, 2) }}</td>
                                        @endforeach
        
                                        @foreach ($transfer as $transfer)
                                            <td> {{ number_format($transfer->transfer, 2) }}</td>
                                        @endforeach
        
                                        @foreach ($bon as $bon)
                                            <td> {{ number_format($bon->total_bon, 2) }}</td>
                                        @endforeach
        
                                        @foreach ($bayarBon as $bb)
                                            <td> {{ number_format($bb->total_bayar_bon, 2) }}</td>
                                        @endforeach
        
                                    @endforeach 
                                </tr>
                            @endfor
                        </tbody>
                    </table>
        
                     <table class="table table-lg table-striped mt-4 table-bordered">
                        <thead>
                            <th>Total Penjualan</th>
                            <th>Total Pokok</th>
                            <th>Total Keuntungan</th>
                            <th>Total Cash</th>
                            <th>Total Transfer</th>
                            <th>Total Bon</th>
                            <th>Total Bayar Bon</th>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($totalPenjualanDanPokok as $tpdp)
                                    <td><b> {{ number_format($tpdp->total_penjualan, 2) }} </b></td>
                                    <td><b> {{ number_format($tpdp->pokok, 2) }} </b></td>
                                    @php
                                     $x=$tpdp->total_penjualan;
                                     $y=$tpdp->pokok;
                                    
                                     $untung=$x-$y;
                                    @endphp
                                    <td><b> {{ number_format($untung, 2) }}<b></td>
                                @endforeach
        
                                @foreach ($totalPenjualanCash as $tpc)
                                    <td><b> {{ number_format($tpc->total_penjualan_cash, 2) }}</b></td>
                                @endforeach
                                @foreach ($totalPenjualanTransfer as $tpt)
                                    <td><b> {{ number_format($tpt->total_penjualan_transfer, 2) }}</b></td>
                                @endforeach
                                @foreach ($totalPenjualanBon as $tpb)
                                    <td><b> {{ number_format($tpb->total_penjualan_bon, 2) }}</b></td>
                                @endforeach
                                @foreach ($totalBayarBon as $tbb)
                                    <td><b> {{ number_format($tbb->total_bayar_bon, 2) }}</b></td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>  
        
                </div><!--card-body-->
            </div><!--tab rekap-->
            <div class="tab-pane fade" id="barang-terjual" role="tabpanel" aria-labelledby="barang-terjual-tab">
                <div class="container-fluid mt-3">
                <table id="tabel-total-barang-terjual" class="table table-responsive-sm table-responsive-lg table-bordered mt-3 table-hover">
                    <thead>
                        <th>Nama Barang</th>
                        @for($i = 0; $i < count($tanggal); $i++) 
                            <th>{{$tanggal[$i]}}</th>
                        @endfor
                        <th>Total Terjual</th>
                    </thead>
                    <tbody>
                        @foreach ($dataBarang as $db)
                            <tr>
                                <td>{{$db->nama_barang}}</td>
                            @for($i = 0; $i < count($tanggal); $i++)
                                @php
                                    $dataBarangTerjual=DB::table('barang_penjualan')
                                    ->join('barang', 'barang.id_barang', '=', 'barang_penjualan.id_barang')
                                    ->select('barang_penjualan.*','barang.nama_barang',DB::raw("SUM(jumlah) as jumlah_barang_terjual"))
                                    ->where('barang_penjualan.id_toko', $idToko)
                                    ->where('barang_penjualan.id_barang', $db->id_barang)
                                    ->where('barang_penjualan.tanggal', $tanggal[$i])->get();

                                    $dataTotalBarangTerjual=DB::select(DB::raw(" 
                                    select *, sum(jumlah) as total_jumlah_barang_terjual from barang_penjualan
                                    INNER JOIN barang ON barang.id_barang=barang_penjualan.id_barang
                                    where barang_penjualan.id_toko = $idToko
                                    and barang_penjualan.id_barang = $db->id_barang"));
                                @endphp

                                @foreach ($dataBarangTerjual as $dbt)
                                    <td>{{ number_format($dbt->jumlah_barang_terjual, 0) }}</td>
                                @endforeach
                            @endfor
                            @foreach ($dataTotalBarangTerjual as $dtbt)
                                <td>{{ number_format($dtbt->total_jumlah_barang_terjual, 0) }}</td>
                            @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div><!--contaner-fluid-->
            </div><!--penjualan-barang tab-->
            <div class="tab-pane fade" id="pembayaran-bon" role="tabpanel" aria-labelledby="pembayaran-bon-tab pt-3">
                <div class="container-fluid mt-3">
                    <h3><b>Tabel Bon</b></h3>
                    <hr>
                    <table class="table table-hover table-bordered dt-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-sm" id="tabel-bon" style="width:100%">
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
                    <table class="table table-striped table-bordered dt-responsive nowrap mt-3" id="tabel-pembayaran-bon">
                        <thead>
                            <tr>
                                <th>No Bon</th>
                                <th>Tanggal</th>
                                <th>Nama Pembeli</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Referral</th>                                   
                                <th>Metode Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarBayarBon as $dbb)
                            <tr>
                                <td>{{$dbb->no_bon}}</td>
                                <td>{{$dbb->tanggal}}</td>
                                <td>{{$dbb->nama_pembeli}}</td>
                                <td>{{ number_format($dbb->jumlah_pembayaran, 2) }}</td>
                                <td>{{$dbb->metode_pembayaran}}</td>
                                <td>{{$dbb->referral}}</td>                                  
                                <td>{{$dbb->nama_bank}}</td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!--container-->
            </div><!--pembayaran-bon tab-->
        </div><!--tabs-->
    </div><!--card-->
</div><!--container-fluid-->
@endsection