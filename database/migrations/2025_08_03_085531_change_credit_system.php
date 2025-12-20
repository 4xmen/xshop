<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add credit column to customers table if not exists
        if (!Schema::hasColumn('customers', 'credit')) {
            Schema::table('customers', function (Blueprint $table) {
                $table->decimal('credit', 20, 2)->default(0)->after('password');
                $table->index('credit');
            });
        }

        // Update credits table structure
        Schema::table('credits', function (Blueprint $table) {
            if (!Schema::hasColumn('credits', 'type')) {
                $table->string('type')->default('CHARGE')->after('amount');
            }
            if (!Schema::hasColumn('credits', 'status')) {
                $table->string('status')->default('COMPLETED')->after('type');
            }
            if (!Schema::hasColumn('credits', 'payment_id')) {
                $table->foreignId('payment_id')->nullable()->constrained()->after('customer_id');
            }
            if (!Schema::hasColumn('credits', 'invoice_id')) {
                $table->foreignId('invoice_id')->nullable()->constrained()->after('payment_id');
            }
            if (!Schema::hasColumn('credits', 'reference_id')) {
                $table->string('reference_id')->nullable()->after('invoice_id');
            }
            if (!Schema::hasColumn('credits', 'description')) {
                $table->text('description')->nullable()->after('reference_id');
            }
            if (!Schema::hasColumn('credits', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('description');
            }

            // Rename 'data' column to avoid conflict and ensure it's JSON
            if (Schema::hasColumn('credits', 'data') ) {
                if (DB::connection()->getDriverName() === 'pgsql') {
                    DB::statement('ALTER TABLE credits ALTER COLUMN data TYPE json USING data::json');
                }
                $table->json('data')->nullable()->change();
            }

            // Add indexes
            $table->index(['customer_id', 'type']);
            $table->index(['customer_id', 'status']);
            $table->index('processed_at');
        });

        // Add credit type to Payment model types
        Schema::table('payments', function (Blueprint $table) {
            // This will be handled by updating the Payment model's $types array
        });
    }
};
