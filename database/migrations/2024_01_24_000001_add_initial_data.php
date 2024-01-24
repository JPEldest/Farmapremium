<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('users')->insert([
            'id' => '2c16c53d-2845-43cd-aae2-392dc7935921',
            'given_name' => 'John',
            'surname' => 'Doe',
            'email' => 'john.doe@example.com',
            'balance' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('pharmacies')->insert([
            'id' => 'e92b9215-e544-42a2-97a1-7ea548c15374',
            'name' => 'Pharmacy A',
            'address' => '123 Main Street',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('transactions')->insert([
            'id' => '8cedfd4f-21e5-413e-aba4-7ac059e279f1',
            'user_id' => DB::table('users')->first()->id,
            'pharmacy_id' => DB::table('pharmacies')->first()->id,
            'points' => 50,
            'transaction_type' => 'give',
            'points_left' => 50,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('pharmacies');
        Schema::dropIfExists('users');
    }
};
