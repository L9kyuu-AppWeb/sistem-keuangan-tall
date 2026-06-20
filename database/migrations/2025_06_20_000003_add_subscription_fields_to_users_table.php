<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_pro')->default(false);
            $table->timestamp('pro_expires_at')->nullable();
            $table->foreignId('family_group_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('family_role')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_pro', 'pro_expires_at', 'family_group_id', 'family_role']);
        });
    }
};
