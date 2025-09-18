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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_assessor_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('document_title');
            $table->string('slea_section'); // Leadership Excellence, Community Engagement, etc.
            $table->string('subsection')->nullable();
            $table->string('role_in_activity')->nullable();
            $table->date('activity_date')->nullable();
            $table->string('organizing_body')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned', 'flagged'])->default('pending');
            $table->decimal('auto_generated_score', 5, 2)->nullable(); // System calculated score
            $table->decimal('assessor_score', 5, 2)->nullable(); // Assessor override score
            $table->text('assessor_remarks')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('return_reason')->nullable();
            $table->text('flag_reason')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
