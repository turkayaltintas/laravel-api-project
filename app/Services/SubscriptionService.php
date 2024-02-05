<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

class SubscriptionService
{
    /**
     * Belirli bir kullanıcıya ait abonelikleri ve ilişkili işlemleri listeler.
     *
     * @param int $userId Kullanıcı ID'si
     * @return Collection
     */
    public function getSubscriptionsByUser(int $userId): Collection
    {
        return Subscription::with(['transactions'])
            ->where('user_id', $userId)->get();
    }

    /**
     * Kullanıcı için yeni bir abonelik oluşturur.
     *
     * @param int $userId Kullanıcı ID'si
     * @param array $data Doğrulanmış veriler
     * @return Subscription
     */
    public function createSubscription(int $userId, array $data): Subscription
    {
        $user = User::findOrFail($userId);
        return $user->subscriptions()->create($data);
    }
    /**
     * Var olan bir aboneliği günceller.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $subscriptionId Abonelik ID'si
     * @param array $data Güncellenmiş veriler
     * @return Subscription
     */
    public function updateSubscription(int $userId, int $subscriptionId, array $data): Subscription
    {
        $subscription = Subscription::where('id', $subscriptionId)
            ->where('user_id', $userId)
            ->firstOrFail();
        $subscription->update($data);
        return $subscription;
    }

    /**
     * Belirli bir kullanıcının tüm aboneliklerini siler.
     *
     * @param int $userId Kullanıcı ID'si
     * @return int Silinen aboneliklerin sayısı
     */
    public function deleteSubscriptions(int $userId): int
    {
        $user = User::findOrFail($userId);
        return $user->subscriptions()->delete();
    }

    /**
     * Yenilenmesi gereken abonelikleri listeler.
     *
     * @return Collection
     */
    public function getSubscriptionsNeedingRenewal(): Collection
    {
        return Subscription::whereDate('expired_at', '=', now()->format('Y-m-d'))->get();
    }

    /**
     * Aboneliği yeniler.
     *
     * @param int $subscriptionId Abonelik ID'si
     * @return Subscription Yenilenen abonelik
     */
    public function renewSubscription(int $subscriptionId): Subscription
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->update([
            'renewed_at' => now(),
            'expired_at' => now()->addMonth(),
        ]);
        return $subscription;
    }
}
