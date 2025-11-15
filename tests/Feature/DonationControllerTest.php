<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function user_can_view_their_donations_page()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('donations.my'));

        $response->assertStatus(200);
        $response->assertViewIs('donations.my-donations');
    }

    /** @test */
    public function guest_cannot_view_donations_page()
    {
        $response = $this->get(route('donations.my'));

        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_create_a_donation()
    {
        $this->actingAs($this->user);

        $donationData = [
            'currency' => 'USD',
            'amount' => 100.50,
            'description' => 'Test donation',
        ];

        $response = $this->post(route('donations.store'), $donationData);

        $response->assertRedirect(route('donations.my'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('donations', [
            'user_id' => $this->user->id,
            'currency' => 'USD',
            'amount' => 100.50,
            'description' => 'Test donation',
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function user_can_get_donation_stats_via_api()
    {
        $this->actingAs($this->user);

        // Create some donations
        Donation::factory()->count(3)->completed()->create([
            'user_id' => $this->user->id,
            'currency' => 'USD',
            'amount' => 100,
        ]);

        $response = $this->getJson(route('donations.api.stats'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => ['currency', 'count', 'total', 'average', 'min', 'max']
        ]);

        $responseData = $response->json();
        $this->assertEquals(1, count($responseData));
        $this->assertEquals('USD', $responseData[0]['currency']);
        $this->assertEquals(3, $responseData[0]['count']);
    }

    /** @test */
    public function donation_creation_requires_valid_data()
    {
        $this->actingAs($this->user);

        // Test with missing data
        $response = $this->post(route('donations.store'), []);

        $response->assertSessionHas('error');
        $response->assertRedirect();

        // Test with invalid amount
        $response = $this->post(route('donations.store'), [
            'currency' => 'USD',
            'amount' => -50,
        ]);

        $response->assertSessionHas('error');
        $response->assertRedirect();
    }

    /** @test */
    public function user_can_see_their_donation_statistics()
    {
        $this->actingAs($this->user);

        // Create donations in different currencies
        Donation::factory()->count(2)->completed()->create([
            'user_id' => $this->user->id,
            'currency' => 'USD',
            'amount' => 100,
        ]);

        Donation::factory()->count(3)->completed()->create([
            'user_id' => $this->user->id,
            'currency' => 'EUR',
            'amount' => 50,
        ]);

        $response = $this->get(route('donations.my'));

        $response->assertStatus(200);
        $response->assertSee('USD');
        $response->assertSee('EUR');
        $response->assertSee('2'); // USD count
        $response->assertSee('3'); // EUR count
    }

    /** @test */
    public function user_can_see_recent_donations()
    {
        $this->actingAs($this->user);

        // Create donations
        $recentDonation = Donation::factory()->completed()->create([
            'user_id' => $this->user->id,
            'currency' => 'USD',
            'amount' => 100,
            'description' => 'Recent donation',
        ]);

        $response = $this->get(route('donations.my'));

        $response->assertStatus(200);
        $response->assertSee('100.00');
        $response->assertSee('USD');
        $response->assertSee('Recent donation');
    }
}