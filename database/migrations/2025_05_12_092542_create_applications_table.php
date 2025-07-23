<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company');
            $table->string('position');
            $table->enum('status', ['Wishlist', 'Applied', 'Interviewing', 'Offered', 'Rejected', 'Accepted'])->default('Applied');
            $table->date('applied_on')->nullable();
            $table->date('deadline')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->string('job_link')->nullable();
            $table->string('resume_used')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
