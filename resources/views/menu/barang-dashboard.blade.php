@extends('layouts.app')

@section('content')
<section id="barang-dashboard">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4><b>Kelola Barang</b></h4>
            </div><!--card-header-->
            <div class="card-body">
                <table id="tabel-barang" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <th>No.</th>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Harga Pokok</th>
                        <th>Harga Jual</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 1</td>
                            <td>Data 1</td>
                            <td>Data 1</td>
                            <td>Data 1</td>
                        </tr>
                    </tbody>
                </table>
            </div><!--card-body-->
        </div><!--card-->
    </div><!--container-->
</section>

<script>
    $(document).ready(function() {
        $('#tabel-barang').DataTable();
    } );
</script>
@endsection