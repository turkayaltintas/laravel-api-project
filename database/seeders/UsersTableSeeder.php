<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'turkotrko2@gmail.com',
            'name' => 'Türkay ALTINTAŞ',
            'password' => '123456'
        ]);
        $subscription = $user->subscriptions()->create(['renewed_at' =>  now()->format('Y-m-d'), 'expired_at' => now()->addMonth(1)->format('Y-m-d')]);
        $subscription->transactions()->create(['price' => 39, 'status' => true]);
    }
}
