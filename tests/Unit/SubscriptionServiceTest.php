<?php

namespace Tests\Unit;

use Tests\TestCase;

class SubscriptionServiceTest extends TestCase
{
    /**
     * Verifies the response when the 'renewed_at' field is missing in the subscription request.
     */
    public function testMissingRenewedAtFieldError(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/2/subscription', [
            'renewed_at' => '',
            'expired_at' => now()->addMonth(1)->format('Y-m-d')
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Verifies the response when the 'expired_at' field is missing in the subscription request.
     */
    public function testMissingExpiredAtFieldError(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/1/subscription', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => '',
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Confirms successful subscription creation.
     */
    public function testSuccessfulSubscriptionCreation(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/1/subscription', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => now()->addMonth(1)->format('Y-m-d'),
        ]);

        $response->assertCreated();
    }

    /**
     * Asserts that subscription update works as expected.
     */
    public function testSuccessfulSubscriptionUpdate(): void
    {
        $this->loginUser();

        $response = $this->putJson('api/user/1/subscription/2', [
            'renewed_at' => now()->format('Y-m-d'),
            'expired_at' => now()->addMonth(1)->format('Y-m-d'),
        ]);

        $response->assertOk();
    }

    public function testListSubscriptionSuccessfully(): void
    {
        $this->loginUser();

        $response = $this->getJson('api/user/2');

        $response->assertOk(200);
    }

}
