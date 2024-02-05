<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function loginUser()
    {
        $user = User::where('email', 'turkotrko@gmail.com')->firstOrFail();

        $this->actingAs($user);
    }
}
