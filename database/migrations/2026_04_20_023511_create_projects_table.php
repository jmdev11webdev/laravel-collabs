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
        $table->string('title');
        $table->text('description')->nullable();
        $table->string('link')->nullable();
        $table->string('repository')->nullable();
        $table->string('starter_kit')->default('No Starter Kit');
        $table->timestamps();
    });
        // chk stands for check for checking constraints
        DB::statement("
            ALTER TABLE projects
            ADD CONSTRAINT chk_starter_kit
            CHECK (starter_kit IN ('$values'))
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE projects DROP CONSTRAINT chk_starter_kit');
        Schema::dropIfExists('projects');
    }
};
