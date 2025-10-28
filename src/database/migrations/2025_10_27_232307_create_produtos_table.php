<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->unique();
            $table->text('descricao')->nullable();
            $table->decimal('preco', 12, 2);
            $table->unsignedInteger('quantidade_estoque')->default(0);
            $table->json('categoria')->nullable();
            $table->json('atributo')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['preco', 'quantidade_estoque']);
        });

        Schema::table('produtos', function (Blueprint $table) {
            DB::statement('ALTER TABLE produtos ADD CONSTRAINT chk_preco_non_negative CHECK (preco >= 0)');
            DB::statement('ALTER TABLE produtos ADD CONSTRAINT chk_quantidade_estoque_non_negative CHECK (quantidade_estoque >= 0)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
