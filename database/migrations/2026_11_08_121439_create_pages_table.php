<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Logging\OpenTestReporting\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //Schema::disableForeignKeyConstraints();
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->string('slug')->unique()->index();
            $table->text('subtitle');
            $table->longText('body');
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedInteger('view')->default(0);
            $table->string('icon', 128)->nullable();
            $table->json('theme')->nullable();
            $table->text('canonical')->nullable();
            $table->unsignedInteger('parent_id')->nullable()->default(null)->index();
            $table->text('markups')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //$table->foreign('parent_id')->references('id')->on('pages');
        });


        if (version_compare(config('app.version'), '3.6.0', '<=')) {
            Schema::table('settings', function (Blueprint $table) {
                if (DB::connection()->getDriverName() !== 'pgsql') {
                    $table->enum('type', \App\Models\Setting::$settingTypes)->change();
                }
            });

            if (DB::connection()->getDriverName() === 'pgsql') {
                DB::statement('ALTER TABLE settings DROP CONSTRAINT IF EXISTS settings_type_check');

                $values = collect(\App\Models\Setting::$settingTypes)
                    ->map(fn ($value) => DB::getPdo()->quote($value))
                    ->implode(', ');

                DB::statement(
                    "ALTER TABLE settings ADD CONSTRAINT settings_type_check CHECK (type IN ($values))"
                );
            }
        }



        // add field
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
