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
            $table->float('production_cost', 10, 2);
            $table->float('price', 10, 2);
            $table->integer('quantity_produced');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};