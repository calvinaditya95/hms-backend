<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatTindakanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_tindakan', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('id_jenis_obat')->unsigned();
            $table->foreign('id_jenis_obat')
                  ->references('id')->on('jenis_obat')
                  ->onDelete('restrict');                        
            
            $table->integer('id_obat_masuk')->unsigned();
            $table->foreign('id_obat_masuk')
                  ->references('id')->on('obat_masuk')
                  ->onDelete('restrict');
                  
            $table->dateTime('waktu_keluar');   // Atau pakai timestamp?    
            $table->integer('jumlah');  
            $table->string('keterangan');   
            
            $table->integer('asal')->unsigned();                     
            $table->foreign('asal')
                  ->references('id')->on('lokasi_obat')
                  ->onDelete('restrict');

            $table->integer('id_transaksi')->unsigned();  
            $table->integer('id_tindakan')->unsigned();    
                  
            $table->timestamps();               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obat_tindakan');
    }
}
