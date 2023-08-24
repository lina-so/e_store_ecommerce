<?php

use App\Models\Vendor;
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
        Schema::create('vendor_business_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vendor::class);
            $table->string('shop_name');
            $table->string('shop_address');
            $table->string('shop_city');
            $table->string('shop_country');
            $table->string('shop_mobile');
            $table->string('shop_email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_business_details');
    }
};
