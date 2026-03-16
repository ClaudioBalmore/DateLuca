<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicDonationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_donate_from_public_profile(): void
    {
        $profileOwner = User::factory()->create(['slug' => 'creador']);

        $response = $this->post(route('donations.public.store', ['slug' => $profileOwner->slug]), [
            'donor_name' => 'Visitante',
            'message' => 'Sigue asi',
            'lucas' => 5,
            'card_number' => '4242424242424242',
            'card_expiry' => '08/29',
            'card_cvv' => '123',
        ]);

        $response->assertRedirect(route('dashboard.slug', ['slug' => $profileOwner->slug]));

        $this->assertDatabaseHas('donations', [
            'user_id' => $profileOwner->id,
            'donor_name' => 'Visitante',
            'message' => 'Sigue asi',
            'amount' => 5000,
        ]);
    }

    public function test_authenticated_user_donation_uses_account_name(): void
    {
        $profileOwner = User::factory()->create(['slug' => 'streamer']);
        $donor = User::factory()->create(['name' => 'Luca Fan']);

        $response = $this
            ->actingAs($donor)
            ->post(route('donations.public.store', ['slug' => $profileOwner->slug]), [
                'donor_name' => 'Nombre Alterado',
                'message' => 'Buen contenido',
                'lucas' => 2,
                'card_number' => '5555444433332222',
                'card_expiry' => '12/30',
                'card_cvv' => '999',
            ]);

        $response->assertRedirect(route('dashboard.slug', ['slug' => $profileOwner->slug]));

        $donation = Donation::query()->latest('id')->first();

        $this->assertNotNull($donation);
        $this->assertSame($profileOwner->id, $donation->user_id);
        $this->assertSame($donor->name, $donation->donor_name);
        $this->assertSame('Buen contenido', $donation->message);
        $this->assertSame('2000.00', number_format((float) $donation->amount, 2, '.', ''));
    }

    public function test_owner_cannot_donate_to_own_profile(): void
    {
        $profileOwner = User::factory()->create(['slug' => 'owner']);

        $response = $this
            ->actingAs($profileOwner)
            ->from(route('dashboard.slug', ['slug' => $profileOwner->slug]))
            ->post(route('donations.public.store', ['slug' => $profileOwner->slug]), [
                'donor_name' => 'Yo mismo',
                'message' => 'Autodonacion',
                'lucas' => 1,
                'card_number' => '1234123412341234',
                'card_expiry' => '07/28',
                'card_cvv' => '111',
            ]);

        $response
            ->assertSessionHasErrors('lucas')
            ->assertRedirect(route('dashboard.slug', ['slug' => $profileOwner->slug]));

        $this->assertDatabaseCount('donations', 0);
    }

    public function test_payment_fields_are_validated_for_public_donations(): void
    {
        $profileOwner = User::factory()->create(['slug' => 'validaciones']);

        $response = $this->from(route('dashboard.slug', ['slug' => $profileOwner->slug]))
            ->post(route('donations.public.store', ['slug' => $profileOwner->slug]), [
                'donor_name' => 'Visitante',
                'message' => str_repeat('x', 51),
                'lucas' => 101,
                'card_number' => '123',
                'card_expiry' => '15/50',
                'card_cvv' => '1',
            ]);

        $response
            ->assertSessionHasErrors(['message', 'lucas', 'card_number', 'card_expiry', 'card_cvv'])
            ->assertRedirect(route('dashboard.slug', ['slug' => $profileOwner->slug]));
    }
}
