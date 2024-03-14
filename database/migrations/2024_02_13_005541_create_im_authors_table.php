<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('im_authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('im_id')->constrained('ims');
            $table->foreignId('author_id')->constrained('authors');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('im_authors');
    }
};