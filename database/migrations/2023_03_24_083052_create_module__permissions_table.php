<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('module__permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modules_id')->constrained('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('add_access')->default(false);
            $table->boolean('delete_access')->default(false);           
            $table->boolean('view_access')->default(false);
            $table->boolean('edit_access')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module__permissions');
    }
};
