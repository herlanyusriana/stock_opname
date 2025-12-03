<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $fk = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'parts')
            ->where('COLUMN_NAME', 'vendor_id')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        if ($fk) {
            DB::statement("ALTER TABLE `parts` DROP FOREIGN KEY `{$fk}`");
        }

        Schema::table('parts', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->change();

            if (Schema::hasColumn('parts', 'sku')) {
                $table->string('sku')->nullable()->change();
            }

            if (Schema::hasColumn('parts', 'uom')) {
                $table->string('uom', 50)->nullable()->change();
            }

            if (Schema::hasColumn('parts', 'description')) {
                $table->text('description')->nullable()->change();
            }

            if (!Schema::hasColumn('parts', 'customer')) {
                $table->string('customer')->nullable()->after('vendor_id');
            }
            if (!Schema::hasColumn('parts', 'part_number')) {
                $table->string('part_number')->nullable()->after('customer');
            }
            if (!Schema::hasColumn('parts', 'part_name')) {
                $table->string('part_name')->nullable()->after('part_number');
            }
            if (!Schema::hasColumn('parts', 'category')) {
                $table->string('category')->nullable()->after('part_name');
            }
            if (!Schema::hasColumn('parts', 'style_bom')) {
                $table->string('style_bom')->nullable()->after('category');
            }
        });

        // Backfill part_number from sku before adding unique index
        DB::table('parts')->where(function ($q) {
            $q->whereNull('part_number')->orWhere('part_number', '');
        })->update([
            'part_number' => DB::raw("COALESCE(NULLIF(sku, ''), CONCAT('PN-', id))"),
        ]);

        $hasIndex = DB::table('information_schema.statistics')
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'parts')
            ->where('COLUMN_NAME', 'part_number')
            ->exists();

        if (!$hasIndex) {
            Schema::table('parts', function (Blueprint $table) {
                $table->unique('part_number');
            });
        }
    }

    public function down(): void
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropUnique(['part_number']);
            $table->dropColumn(['customer', 'part_number', 'part_name', 'category', 'style_bom']);
            $table->string('sku')->nullable(false)->change();
            $table->string('uom', 50)->nullable(false)->change();
            $table->text('description')->nullable(false)->change();
            $table->foreignId('vendor_id')->nullable(false)->change();
        });

        DB::statement('ALTER TABLE `parts` ADD CONSTRAINT `parts_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors`(`id`) ON DELETE CASCADE');
    }
};
