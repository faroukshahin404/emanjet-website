<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->integer('attempts')->default(0)->after('is_used');
            $table->timestamp('blocked_until')->nullable()->after('attempts');
            $table->index(['phone', 'created_at']);
        });
    }

    public function down()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->dropColumn(['attempts', 'blocked_until']);
            $table->dropIndex(['phone', 'created_at']);
        });
    }
};
