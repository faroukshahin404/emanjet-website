<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * App store links are managed in Dash settings only (Mobile App Links).
     */
    public function up(): void
    {
        DB::table('page_seos')->where('section_type', 'apps')->delete();
    }

    public function down(): void
    {
        // Irreversible: content was moved to dash_settings.
    }
};
