<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');
            $table->string('kode_produk');
            $table->string('nama_produk');
            $table->string('merk')->nullable();
            $table->string('stok');
            $table->integer('min_stok');
            $table->string('satuan');
            $table->integer('status');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')
                ->on('kategoris')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
};
