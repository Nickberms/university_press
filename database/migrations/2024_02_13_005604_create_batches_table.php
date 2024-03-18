<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('im_id')->constrained('ims');
            $table->string('name');
            $table->date('production_date');
            $table->float('production_cost');
            $table->float('price');
            $table->integer('quantity_produced');
            $table->integer('available_stocks');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};