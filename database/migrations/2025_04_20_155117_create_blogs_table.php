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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان المدونة
            $table->text('content'); // محتوى المدونة
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained('blog_categories')->onDelete('cascade'); // ربط المدونة بالفئة
            $table->integer('views')->default(0); // عدد المشاهدات
            $table->integer('likes')->default(0); // عدد الإعجابات
            $table->integer('reading_time')->default(0); // مدة القراءة بالدقائق
            $table->string('meta_title')->nullable(); // العنوان الميتا
            $table->text('meta_description')->nullable(); // الوصف الميتا
            $table->json('meta_tags')->nullable(); // الكلمات المفتاحية أو البيانات الخاصة بـ og
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
