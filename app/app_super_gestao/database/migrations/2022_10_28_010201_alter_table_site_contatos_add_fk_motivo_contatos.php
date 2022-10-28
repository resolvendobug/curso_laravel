<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        //add coluna motivo_contato_id
        Schema::table('site_contatos', function (Blueprint $table) { 
            $table->unsignedBigInteger('motivo_contato_id');
        });

        //atribuindo valor de motivo_contato em motivo_contato_id
        DB::statement('update site_contatos set motivo_contato_id = motivo_contato');
        
        Schema::table('site_contatos', function (Blueprint $table) {
            $table->foreign('motivo_contato_id')->references('id')->on('motivo_contatos');
            $table->dropColumn('motivo_contato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        //criando coluna motivo_contato removendo foreign motivo_contato_id
        Schema::table('site_contatos', function (Blueprint $table) { 
            $table->integer('motivo_contato');
            $table->dropForeign('site_contatos_motivo_contato_id_foreign'); //<table>_<coluna>_foreign
            
        });

        //atribuindo valor de motivo_contato_id em motivo_contato
        DB::statement('update site_contato set  motivo_contato = motivo_contato_id');
        
        //apagando coluna motivo_contato_id
        Schema::table('site_contatos', function (Blueprint $table) {
            $table->dropColumn('motivo_contato_id');
        });
    }
};
