<?php

namespace Tests\Feature;

use App\Livewire\Paywall;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class PaywallTest extends TestCase
{
    use RefreshDatabase;

    public function test_paywall_renders_correctly()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('paywall'));

        $response->assertStatus(200);
        $response->assertSee('FamiBalance Pro');
    }

    public function test_pay_method_dispatches_initiate_payment_event_with_snap_token()
    {
        $user = User::factory()->create();

        Http::fake([
            'https://app.sandbox.midtrans.com/snap/v1/transactions' => Http::response([
                'token' => 'mock-snap-token-12345',
                'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v1/pay?token=mock-snap-token-12345',
            ], 201),
        ]);

        Livewire::actingAs($user)
            ->test(Paywall::class)
            ->call('pay', 'yearly')
            ->assertDispatched('initiate-payment', token: 'mock-snap-token-12345');
    }

    public function test_payment_completed_listener_verifies_payment_and_activates_pro()
    {
        $user = User::factory()->create([
            'is_pro' => false,
            'pro_expires_at' => null,
        ]);

        $orderId = 'FAMI-'.$user->id.'-yearly-'.time();

        Http::fake([
            "https://api.sandbox.midtrans.com/v2/{$orderId}/status" => Http::response([
                'transaction_status' => 'settlement',
                'status_code' => '200',
                'gross_amount' => '249000.00',
            ], 200),
        ]);

        Livewire::actingAs($user)
            ->test(Paywall::class)
            ->call('handlePaymentCompleted', [
                'order_id' => $orderId,
            ])
            ->assertRedirect(route('paywall'));

        $user->refresh();
        $this->assertTrue($user->is_pro);
        $this->assertNotNull($user->pro_expires_at);
        $this->assertTrue($user->pro_expires_at->isAfter(now()->addMonths(11)));
    }
}
