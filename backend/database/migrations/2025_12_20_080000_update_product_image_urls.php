<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateProductImageUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $base = config('app.url') ?: env('APP_URL', 'https://sweet-bite-bakery-system.onrender.com');

        // Convert relative storage paths (e.g. storage/products/...) to absolute URLs
        DB::table('products')
            ->whereNotNull('image_url')
            ->whereRaw("image_url NOT LIKE 'http%'")
            ->update(['image_url' => DB::raw("CONCAT('" . $base . "', '/', image_url)")]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $base = config('app.url') ?: env('APP_URL', 'https://sweet-bite-bakery-system.onrender.com');

        DB::table('products')
            ->where('image_url', 'like', $base . '/%')
            ->update(['image_url' => DB::raw("REPLACE(image_url, '" . $base . "' || '/', '')")]);
    }
}
