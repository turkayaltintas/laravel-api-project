<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use App\Transformers\TransactionTransformer;

class TransactionController extends Controller
{
    /**
     * Transaction servis sınıfı ile iletişim kurar.
     */
    public function __construct(private TransactionService $transactionService)
    {
    }

    /**
     * Yeni bir işlem kaydı oluşturur ve saklar.
     *
     * İşlem verileri, HTTP isteği ile birlikte gelen ve doğrulanmış
     * veriler kullanılarak oluşturulur. Başarılı bir şekilde oluşturulan
     * işlem, bir Transformer aracılığıyla işlenir ve API cevabı olarak
     * döndürülür.
     *
     * @param TransactionRequest $request Kullanıcıdan gelen istek
     * @param int $userId Kullanıcının ID'si
     * @return \Illuminate\Http\JsonResponse Oluşturulan işlem verisi ve HTTP durum kodu ile birlikte döndürülür.
     */
    public function store(TransactionRequest $request, int $userId)
    {
        $transaction = $this->transactionService->createPaymentForSubscription($userId, $request->validated());

        return ApiResponse::send(201, fractal($transaction, new TransactionTransformer()), 'Transaction Added');
    }
}
