<?php

namespace Tests\Unit;

use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    /**
     * Verifies the response when the 'subscription_id' field is missing in the transaction request.
     */
    public function testMissingSubscriptionIdFieldError(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/2/transaction', [
            'subscription_id' => '',
            'price' => 39
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Verifies the response when the 'price' field is missing in the transaction request.
     */
    public function testMissingPriceFieldError(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/2/transaction', [
            'subscription_id' => 1,
            'price' => ''
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Verifies the response when the requested subscription is not found.
     */
    public function testMissingTransactionSubscriptionError(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/9999/transaction', [
            'subscription_id' => 1,
            'price' => 39
        ]);

        $response->assertNotFound();
    }

    /**
     * Confirms successful addition of a transaction.
     */
    public function testSuccessfulTransactionAddition(): void
    {
        $this->loginUser();

        $response = $this->postJson('api/user/2/transaction', [
            'subscription_id' => 2,
            'price' => 39
        ]);

        $response->assertCreated();
    }
}
