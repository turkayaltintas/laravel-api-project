<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class ErrorTransformer extends TransformerAbstract
{
    /**
     * Bir hata mesajını API yanıtı için dönüştürür.
     *
     * @param array $error Hata detaylarını içeren dizi.
     * @return array Dönüştürülmüş hata mesajı.
     */
    public function transform(array $error)
    {
        return [
            'status' => 'error',
            'code' => $error['code'],
            'message' => $error['message'],
            'errors' => $error['errors'] ?? null, // Hata detayları opsiyonel
        ];
    }
}
