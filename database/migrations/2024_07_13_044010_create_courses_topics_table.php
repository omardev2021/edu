<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Topic;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses_topics', function (Blueprint $table) {
            $table->foreignIdFor(Course::class)->constrained()->restrictOnDelete();
            $table->foreignIdFor(Topic::class)->constrained()->restrictOnDelete();


        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses_topics');

    }
};
