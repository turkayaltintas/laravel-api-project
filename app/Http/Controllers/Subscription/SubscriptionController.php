<?php

namespace App\Http\Controllers\Subscription;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Services\SubscriptionService;
use App\Transformers\SubscriptionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function __construct(private SubscriptionService $subscriptionService)
    {

    }

    /**
     * Belirli bir kullanıcıya ait tüm abonelikleri listeler.
     *
     * @param int $id Kullanıcı ID'si
     * @return JsonResponse Abonelik listesi ile birlikte 200 durum kodu döndürür.
     */
    public function list(int $id)
    {
        $subscriptions = $this->subscriptionService->getSubscriptionsByUser($id);
        return ApiResponse::send(200, fractal($subscriptions)->transformWith(new SubscriptionTransformer()), 'Subscriptions list');
    }

    /**
     * Yeni bir abonelik kaydı oluşturur.
     *
     * @param SubscriptionRequest $request Kullanıcıdan gelen istek
     * @param int $userId Kullanıcı ID'si
     * @return JsonResponse Oluşturulan abonelik bilgisi ile birlikte 201 durum kodu döndürür.
     */
    public function store(SubscriptionRequest $request, int $userId): JsonResponse
    {
        $subscription = $this->subscriptionService->createSubscription($userId, $request->validated());

        return ApiResponse::send(201, fractal($subscription)->transformWith(new SubscriptionTransformer()), 'Subscription added');
    }

    /**
     * Mevcut bir aboneliği günceller.
     *
     * @param SubscriptionRequest $request Kullanıcıdan gelen istek
     * @param int $userId Kullanıcı ID'si
     * @param int $subscriptionId Abonelik ID'si
     * @return JsonResponse Güncellenen abonelik bilgisi ile birlikte 200 durum kodu döndürür.
     */
    public function update(SubscriptionRequest $request, int $userId, int $subscriptionId): JsonResponse
    {
        $subscription = $this->subscriptionService->updateSubscription($userId, $subscriptionId, $request->validated());

        return ApiResponse::send(200, fractal($subscription)->transformWith(new SubscriptionTransformer()), 'Subscription updated');
    }

    /**
     * Bir aboneliği siler.
     *
     * @param int $id Abonelik ID'si
     * @return JsonResponse Silme işlemi başarılıysa boş bir cevap ile birlikte 200 durum kodu döndürür.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->subscriptionService->deleteSubscriptions($id);

        return ApiResponse::send(200, null, 'Subscription deleted');
    }

}
