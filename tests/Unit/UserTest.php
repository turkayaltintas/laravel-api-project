<?php

namespace Tests\Unit;

use Tests\TestCase;
use Faker\Factory as Faker;

class UserTest extends TestCase
{
    /**
     * Test user registration with valid data.
     */
    public function testRegisterSuccessfully(): void
    {
        $faker = Faker::create();

        $response = $this->postJson('api/register', [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertCreated();
    }

    /**
     * Test user registration with missing name.
     */
    public function testRegisterNameValidationError(): void
    {
        $faker = Faker::create();

        $response = $this->postJson('api/register', [
            'name' => '',
            'email' => $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Test user registration with missing email.
     */
    public function testRegisterEmailValidationError(): void
    {
        $faker = Faker::create();

        $response = $this->postJson('api/register', [
            'name' => $faker->name,
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Test user registration with missing password.
     */
    public function testRegisterPasswordValidationError(): void
    {
        $faker = Faker::create();

        $response = $this->postJson('api/register', [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => '',
            'password_confirmation' => ''
        ]);

        $response->assertUnprocessable();
    }

    /**
     * Test registration with an already registered user's email.
     * Not: Gerçek bir test ortamında bu testin düzgün çalışabilmesi için öncelikle bir kullanıcı oluşturulmalıdır.
     */
    public function testRegisterExistValidationError(): void
    {
        $faker = Faker::create();

        $this->postJson('api/register', [
            'name' => $faker->name,
            'email' => $existingEmail = $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response = $this->postJson('api/register', [
            'name' => $faker->name,
            'email' => $existingEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertUnprocessable();
    }
}
