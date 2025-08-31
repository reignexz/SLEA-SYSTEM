<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('rubrics', function (Blueprint $table) {
        $table->id();
        $table->string('section_key');           // e.g., leadership
        $table->string('section_label');         // e.g., I. Leadership Excellence
        $table->string('sub_section')->nullable();       // Optional
        $table->string('position_or_title');     // e.g., President
        $table->string('unit_note')->nullable(); // e.g., per day
        $table->string('points');                // Can be number or formula
        $table->string('max_points')->nullable();         // Optional
        $table->string('evidence')->nullable();  // e.g., Certificate
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rubrics');
    }
};
