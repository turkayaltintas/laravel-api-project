<?php

namespace App\Console\Commands;

use App\Services\SubscriptionService;
use App\Services\TransactionService;
use Illuminate\Console\Command;

class UpdateSubscriptionStatus extends Command
{
    /**
     * Konsol komutunun adı ve kullanım şekli.
     *
     * @var string
     */
    protected $signature = 'subscription:update-status';

    /**
     * Konsol komutunun kısa açıklaması.
     *
     * @var string
     */
    protected $description = 'Süresi dolmuş abonelikler için otomatik yenileme işlemlerini gerçekleştirir.';

    /**
     * Sınıfın constructor metodunda bağımlılıklar tanımlanıyor.
     */
    public function __construct(private SubscriptionService $subscriptionService, private TransactionService $transactionService, private bool $automaticRenewal = true)
    {
        parent::__construct();
    }

    /**
     * Konsol komutunun işlemlerini yürütür.
     */
    public function handle()
    {
        $subscriptionsNeedingRenewal = $this->subscriptionService->getSubscriptionsNeedingRenewal();

        foreach ($subscriptionsNeedingRenewal as $subscription) {
            if ($this->automaticRenewal) {
                $this->transactionService->createPaymentForSubscription($subscription->owner_id, [
                    'subscription_id' => $subscription->id,
                    'amount' => 39,
                    'successful' => true
                ]);
                $this->subscriptionService->renewSubscription($subscription->id);
            }
        }

        $this->info('Süresi dolmuş abonelikler başarıyla yenilendi.');

        return 0;
    }
}
