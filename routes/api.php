<?php

use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|

    Kullanıcı Kaydı ve Girişi:
        Kullanıcı kaydı için bir POST rota (/register).
        Kullanıcı girişi için bir POST rota (/login).

    Abonelik Yönetimi:
        Abonelik oluşturma için bir POST rota (/subscriptions).
        Abonelikleri listelemek için bir GET rota (/subscriptions).
        Abonelik güncelleme için bir PUT/PATCH rota (/subscriptions/{id}).
        Abonelik silme için bir DELETE rota (/subscriptions/{id}).

    Ödeme İşlemleri:
        Ödeme yapmak için bir POST rota (/payments).

    Kullanıcı Bilgileri:
        Kullanıcı profilini görüntülemek için bir GET rota (/user).

*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(static function () {
    Route::get('user/{id}', [SubscriptionController::class, 'list']);
    Route::post('user/{userId}/subscription', [SubscriptionController::class, 'store']);
    Route::put('user/{userId}/subscription/{subscriptionId}', [SubscriptionController::class, 'update']);
    Route::delete('user/{userId}/subscription', [SubscriptionController::class, 'destroy']);
    Route::post('user/{userId}/transaction', [TransactionController::class, 'store']);
});
