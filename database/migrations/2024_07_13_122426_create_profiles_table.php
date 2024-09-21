<?php

use App\Models\Slide;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->string('name');
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('email');
            $table->string('phone');
            $table->string('university');
            $table->string('job_title');
            $table->string('city');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
