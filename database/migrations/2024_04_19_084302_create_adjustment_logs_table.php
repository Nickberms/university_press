<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('adjustment_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_deducted');
            $table->string('adjustment_cause');
            $table->foreignId('im_id')->constrained('ims');
            $table->foreignId('batch_id')->constrained('batches');
            $table->date('date_adjusted');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('adjustment_logs');
    }
};