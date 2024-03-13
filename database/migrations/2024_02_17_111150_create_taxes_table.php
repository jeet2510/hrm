<?php

// database/migrations/xxxx_xx_xx_create_taxes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('percentage', 5, 2);
            $table->json('allowance_ids')->nullable();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('taxes');
    }
}

