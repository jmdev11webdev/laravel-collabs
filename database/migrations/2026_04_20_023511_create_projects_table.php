<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Constants\StarterKits;

return new class extends Migration
{
    
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $values = implode("','", StarterKits::ALL); // for values that will be selected
        
        Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('link')->nullable();
        $table->string('repository')->nullable();
        $table->string('starter_kit')->default('No Starter Kit');
        $table->string('status')->default('open');
        $table->boolean('is_public')->default(false);
        $table->date('deadline')->nullable();
        $table->unsignedInteger('max_collaborators')->nullable();
        $table->string('contact_email');
        $table->timestamps();
    });
        // since we are useing postgres, we are only requiring pgsql
        if (DB::getDriverName() === 'pgsql') {
            // chk stands for check for checking constraints
            DB::statement("
                ALTER TABLE projects
                ADD CONSTRAINT chk_starter_kit
                CHECK (starter_kit IN ('$values'))
            ");

            // chk stands for check for checking constraints
            // status constraints
            DB::statement("
                ALTER TABLE projects
                ADD CONSTRAINT chk_status
                CHECK (status IN ('open', 'in_progress', 'completed', 'cancelled'))
            ");

            // chk stands for check for checking constraints
            // deadline constraints
            DB::statement("
                ALTER TABLE projects
                ADD CONSTRAINT chk_deadline
                CHECK (deadline IS NULL OR deadline >= CURRENT_DATE)
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE projects DROP CONSTRAINT IF EXISTS chk_starter_kit');
            DB::statement('ALTER TABLE projects DROP CONSTRAINT IF EXISTS chk_status');
            DB::statement('ALTER TABLE projects DROP CONSTRAINT IF EXISTS chk_deadline');
        }

        Schema::dropIfExists('projects');
    }
};
