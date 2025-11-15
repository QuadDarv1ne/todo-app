<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get the first user or create one if none exists
        $user = User::first() ?? User::factory()->create();

        // Create some sample donations
        Donation::factory()->count(5)->completed()->create([
            'user_id' => $user->id,
            'currency' => 'USD',
        ]);

        Donation::factory()->count(3)->completed()->create([
            'user_id' => $user->id,
            'currency' => 'EUR',
        ]);

        Donation::factory()->count(2)->completed()->create([
            'user_id' => $user->id,
            'currency' => 'BTC',
        ]);
    }
}