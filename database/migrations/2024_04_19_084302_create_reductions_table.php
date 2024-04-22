<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quantity_deductions', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_deducted');
            $table->string('deduction_cause');
            $table->foreignId('im_id')->constrained('ims');
            $table->foreignId('batch_id')->constrained('batches');
            $table->date('date_deducted');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('quantity_deductions');
    }
};