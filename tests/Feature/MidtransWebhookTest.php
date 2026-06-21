<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MidtransWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_webhook_can_activate_subscription_with_valid_signature()
    {
        $user = User::factory()->create([
            'is_pro' => false,
            'pro_expires_at' => null,
        ]);

        $orderId = 'FAMI-'.$user->id.'-yearly-'.time();
        $statusCode = '200';
        $grossAmount = '249000.00';
        $serverKey = config('services.midtrans.server_key');

        $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $payload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => $signatureKey,
            'transaction_status' => 'settlement',
        ];

        $response = $this->postJson(route('midtrans.webhook'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Webhook processed successfully']);

        $user->refresh();
        $this->assertTrue($user->is_pro);
        $this->assertNotNull($user->pro_expires_at);
        $this->assertTrue($user->pro_expires_at->isAfter(now()->addMonths(11)));

        // Assert notification created
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user->id,
            'title' => '🔑 FamiBalance Pro Aktif!',
        ]);
    }

    public function test_webhook_rejects_invalid_signature()
    {
        $user = User::factory()->create([
            'is_pro' => false,
            'pro_expires_at' => null,
        ]);

        $orderId = 'FAMI-'.$user->id.'-yearly-'.time();
        $statusCode = '200';
        $grossAmount = '249000.00';

        $payload = [
            'order_id' => $orderId,
            'status_code' => $statusCode,
            'gross_amount' => $grossAmount,
            'signature_key' => 'invalid-signature-key',
            'transaction_status' => 'settlement',
        ];

        $response = $this->postJson(route('midtrans.webhook'), $payload);

        $response->assertStatus(400);

        $user->refresh();
        $this->assertFalse($user->is_pro);
    }
}
