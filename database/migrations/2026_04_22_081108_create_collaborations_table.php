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
        Schema::create('collaborations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('developer');
            $table->string('status')->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();

            $table->unique(['project_id', 'user_id']); // prevent duplicate requests
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement("
                ALTER TABLE collaborations
                ADD CONSTRAINT chk_collaboration_status
                CHECK (status IN ('pending', 'accepted', 'rejected'))
            ");

            DB::statement("
                ALTER TABLE collaborations
                ADD CONSTRAINT chk_collaboration_role
                CHECK (role IN ('developer', 'designer', 'tester', 'devops'))
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE collaborations DROP CONSTRAINT IF EXISTS chk_collaboration_status');
            DB::statement('ALTER TABLE collaborations DROP CONSTRAINT IF EXISTS chk_collaboration_role');
        }

        Schema::dropIfExists('collaborations');
    }
};
