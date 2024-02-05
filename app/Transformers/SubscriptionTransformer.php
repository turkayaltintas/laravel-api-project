<?php

namespace App\Transformers;

use App\Models\Subscription;
use League\Fractal\TransformerAbstract;

class SubscriptionTransformer extends TransformerAbstract
{
    public function transform(Subscription $subscription)
    {
        return [
            'id' => (int)$subscription->id,
            'renewed_at' => $subscription->renewed_at,
            'expired_at' => $subscription->expired_at,
            'created_at' => $subscription->created_at,
            'updated_at' => $subscription->updated_at,
        ];
    }
}
