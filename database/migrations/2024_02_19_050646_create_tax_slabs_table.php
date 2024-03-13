<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxSlabsTable extends Migration
{
    public function up()
    {
        Schema::create('tax_slabs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('percentage');
            $table->float('fix_deduction')->nullable();
            $table->boolean('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_slabs');
    }
}
