<?php

namespace App\Http\Controllers\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\TransactionRequest;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->userService->createUser($request->validated());

        return ApiResponse::send(201, fractal($user)->transformWith(new UserTransformer()), 'User Added');
    }


    /**
     * Kullanıcı girişi için kullanılır.
     *
     * Bu metot, kullanıcıdan alınan kimlik doğrulama bilgilerini kontrol eder.
     * Doğrulama başarılı olduğunda, kullanıcının önceki tüm tokenları silinir ve yeni bir token oluşturulur.
     * Oluşturulan yeni token ile birlikte kullanıcı bilgilerini içeren bir yanıt döndürür.
     * Eğer kimlik doğrulama başarısız olursa, kullanıcıya 401 durum kodu ile hata mesajı döndürülür.
     *
     * @param LoginRequest $request Kullanıcıdan gelen giriş isteği, doğrulama kurallarını içerir.
     * @return \Illuminate\Http\JsonResponse Kullanıcı bilgileri ve token veya hata mesajı içeren yanıt.
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();
            $user->tokens()->delete();
            $user->token = $user->createToken($user->email)->plainTextToken;

            return ApiResponse::send(200, fractal($user)->transformWith(new UserTransformer()), 'Successfully Authenticated');
        }

        $response = [
            'code' => 401,
            'message' => 'Login credentials are incorrect. Please verify your details and try again.',
            'data' => null,
            'errors' => null
        ];

        return response()->json($response, 401);
    }

}
