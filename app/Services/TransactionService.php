<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionService
{
    public function __construct(private readonly bool $paymentStatus = true)
    {
    }

    /**
     * Ödeme durumuna göre bir abonelik için ödeme işlemi oluşturur.
     *
     * @param int $userId Kullanıcı ID'si.
     * @param array $details Ödeme detayları.
     * @return Transaction|null Oluşturulan ödeme işlemi veya null.
     * @throws ModelNotFoundException|\Exception
     */
    public function createPaymentForSubscription(int $userId, array $details): ?Transaction
    {
        $user = User::findOrFail($userId);

        $subscription = Subscription::where('user_id', $userId)->findOrFail($details['subscription_id']);

        if ($this->paymentStatus) {
            return $subscription->transactions()->create([
                'price' => $details['price'],
                'status' => true,
            ]);
        } else {
            throw new \Exception('Payment failed');
        }
    }
}
