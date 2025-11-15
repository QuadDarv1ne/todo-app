<?php

namespace Tests\Unit;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_donation()
    {
        $user = User::factory()->create();
        
        $donation = Donation::create([
            'user_id' => $user->id,
            'currency' => 'USD',
            'amount' => 100.50,
            'description' => 'Test donation',
        ]);

        $this->assertDatabaseHas('donations', [
            'id' => $donation->id,
            'user_id' => $user->id,
            'currency' => 'USD',
            'amount' => 100.50,
            'description' => 'Test donation',
        ]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $user = User::factory()->create();
        $donation = Donation::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $donation->user);
        $this->assertEquals($user->id, $donation->user->id);
    }

    /** @test */
    public function it_can_get_stats_by_currency()
    {
        $user = User::factory()->create();
        
        // Create donations
        Donation::factory()->count(3)->create([
            'user_id' => $user->id,
            'currency' => 'USD',
            'amount' => 100,
        ]);

        $stats = Donation::getStatsByCurrency('USD', $user->id);

        $this->assertEquals(3, $stats['count']);
        $this->assertEquals(300, $stats['total']);
        $this->assertEquals(100, $stats['average']);
        $this->assertEquals(100, $stats['min']);
        $this->assertEquals(100, $stats['max']);
    }

    /** @test */
    public function it_can_get_user_stats()
    {
        $user = User::factory()->create();
        
        // Create donations in different currencies
        Donation::factory()->count(2)->create([
            'user_id' => $user->id,
            'currency' => 'USD',
            'amount' => 100,
        ]);

        Donation::factory()->count(3)->create([
            'user_id' => $user->id,
            'currency' => 'EUR',
            'amount' => 50,
        ]);

        $stats = Donation::getUserStats($user->id);

        $this->assertCount(2, $stats);
        
        // Check USD stats
        $usdStats = $stats->firstWhere('currency', 'USD');
        $this->assertEquals(2, $usdStats->count);
        $this->assertEquals(200, $usdStats->total);
        
        // Check EUR stats
        $eurStats = $stats->firstWhere('currency', 'EUR');
        $this->assertEquals(3, $eurStats->count);
        $this->assertEquals(150, $eurStats->total);
    }

    /** @test */
    public function it_casts_amount_to_decimal()
    {
        $donation = Donation::factory()->create(['amount' => 123.45678901]);

        // The amount should be cast to 8 decimal places
        $this->assertEquals(123.45678901, $donation->amount);
    }

    /** @test */
    public function it_can_get_formatted_amount()
    {
        // Test USD formatting
        $donation = Donation::factory()->create([
            'currency' => 'USD',
            'amount' => 123.45
        ]);
        
        $this->assertEquals('123.45', $donation->formatted_amount);
        
        // Test BTC formatting
        $donation = Donation::factory()->create([
            'currency' => 'BTC',
            'amount' => 0.12345678
        ]);
        
        $this->assertEquals('0.12345678', $donation->formatted_amount);
    }

    /** @test */
    public function it_can_get_currency_name_and_symbol()
    {
        $donation = Donation::factory()->create(['currency' => 'USD']);
        
        $this->assertEquals('Доллар США', $donation->currency_name);
        $this->assertEquals('$', $donation->currency_symbol);
        
        $donation = Donation::factory()->create(['currency' => 'BTC']);
        
        $this->assertEquals('Биткойн', $donation->currency_name);
        $this->assertEquals('₿', $donation->currency_symbol);
    }

    /** @test */
    public function it_can_get_total_donation_count()
    {
        $user = User::factory()->create();
        
        // Create donations
        Donation::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $count = Donation::getTotalDonationCount($user->id);
        
        $this->assertEquals(3, $count);
    }

    /** @test */
    public function it_can_get_total_donation_amount()
    {
        $user = User::factory()->create();
        
        // Create donations
        Donation::factory()->create([
            'user_id' => $user->id,
            'amount' => 100
        ]);
        
        Donation::factory()->create([
            'user_id' => $user->id,
            'amount' => 50
        ]);

        $total = Donation::getTotalDonationAmount($user->id);
        
        $this->assertEquals(150, $total);
    }

    /** @test */
    public function it_can_get_recent_donations()
    {
        $user = User::factory()->create();
        
        // Create donations
        $recentDonation = Donation::factory()->create([
            'user_id' => $user->id,
            'amount' => 100
        ]);
        
        $olderDonation = Donation::factory()->create([
            'user_id' => $user->id,
            'amount' => 50,
            'created_at' => now()->subDay()
        ]);

        $recentDonations = Donation::getRecentDonations($user->id, 1);
        
        $this->assertCount(1, $recentDonations);
        $this->assertEquals(100, $recentDonations[0]->amount);
    }
}