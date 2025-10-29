<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->decimal('preco_unitario', 10, 2)->nullable()->after('descricao');
            $table->decimal('preco_total', 10, 2)->nullable()->after('preco_unitario');
        });

        // Migrate data from preco to preco_unitario and compute preco_total
        $connection = DB::connection();
        $products = $connection->table('produtos')->select('id','preco','quantidade_estoque')->get();
        foreach ($products as $p) {
            $unit = (float) ($p->preco ?? 0);
            $qty  = (float) ($p->quantidade_estoque ?? 0);
            $total = round($unit * $qty, 2);
            $connection->table('produtos')->where('id', $p->id)->update([
                'preco_unitario' => $unit,
                'preco_total' => $total,
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn(['preco_unitario','preco_total']);
        });
    }
};

