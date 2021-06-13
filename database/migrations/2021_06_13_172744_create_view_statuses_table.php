<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->criar_view());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_statuses');
    }

    public function criar_view()
    {
        return "CREATE 
        VIEW `view_status` AS
        SELECT 
        `inscritos`.`id` AS `id`,
        `inscritos`.`nome` AS `nome`,
        `inscritos`.`email` AS `email`,
        `inscritos`.`empresa` AS `empresa`,
        `inscritos`.`telefone` AS `telefone`,
        `inscritos`.`celular` AS `celular`,
        `inscritos`.`ocupacao` AS `ocupacao`,
        `transacaos`.`status` AS `status`
    FROM
        (`inscritos`
        JOIN `transacaos`)
    WHERE
        (`inscritos`.`id` = `transacaos`.`id_inscrito`)";
    }
}