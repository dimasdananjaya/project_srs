<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('member', function (Blueprint $table) {
            $table->id('id_member');
            $table->string('nama_member');
            $table->string('no_kontak');
            $table->timestamps();
        });

        Schema::create('periode', function (Blueprint $table) {
            $table->id('id_periode');
            $table->string('periode');
            $table->timestamps();
        });

        Schema::create('bank', function (Blueprint $table) {
            $table->id('id_bank');
            $table->string('nama_bank');
            $table->timestamps();
        });

        Schema::create('toko', function (Blueprint $table) {
            $table->id('id_toko');
            $table->string('nama_toko');
            $table->timestamps();
        });

        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->id('id_toko');
            $table->string('nama_barang');
            $table->string('jenis');
            $table->decimal('harga_pokok',13);
            $table->decimal('harga_jual',13);
            $table->timestamps();

            $table->foreign('id_toko')->references('id_toko')->on('toko');
        });

        Schema::create('penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_member');
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_bank');
            $table->decimal('total_harga_pokok',20);
            $table->decimal('total_harga_jual',20);
            $table->decimal('total_akhir',20);
            $table->decimal('diskon',20);
            $table->string('jenis_pembayaran');
            $table->string('status');
            $table->string('keterangan');
            $table->string('no_bon');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_toko')->references('id_toko')->on('toko');
            $table->foreign('id_user')->references('id_user')->on('users');
            $table->foreign('id_member')->references('id_member')->on('member');
            $table->foreign('id_periode')->references('id_periode')->on('periode');
            $table->foreign('id_bank')->references('id_bank')->on('bank');
        });


        Schema::create('barang_penjualan', function (Blueprint $table) {
            $table->id('id_barang_penjualan');
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_barang');
            $table->unsignedBigInteger('id_periode');
            $table->decimal('total_harga_pokok',13);
            $table->decimal('total_harga_jual',13);
            $table->integer('jumlah');

            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_toko')->references('id_toko')->on('toko');
            $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
            $table->foreign('id_periode')->references('id_periode')->on('periode')->onDelete('cascade');

        });

        Schema::create('pembayaran_bon', function (Blueprint $table) {
            $table->id('id_pembayaran_bon');
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_penjualan');
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_bank');
            $table->date('tanggal');
            $table->string('jenis_pembayaran');
            $table->string('referral');
            $table->decimal('jumlah_pembayaran',20);
            

            $table->foreign('id_toko')->references('id_toko')->on('toko');
            $table->foreign('id_penjualan')->references('id_penjualan')->on('penjualan')->onDelete('cascade');
            $table->foreign('id_periode')->references('id_periode')->on('periode')->onDelete('cascade');
            $table->foreign('id_bank')->references('id_bank')->on('bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
