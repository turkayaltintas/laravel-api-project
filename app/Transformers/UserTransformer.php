<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Bir User nesnesini bir diziye dönüştürür.
     *
     * @param mixed $user User nesnesi
     * @return array Dönüştürülmüş User verisi
     */
    public function transform($user)
    {
        return [
            'id' => (int)$user->id,
            'token' => $user->token,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
