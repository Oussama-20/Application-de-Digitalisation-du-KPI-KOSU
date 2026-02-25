<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        Account::create([
            'email'=>'methodes@test.com',
            'password'=>Hash::make('123456'),
            'role'=>'methodes'
        ]);

        Account::create([
            'email'=>'shift@test.com',
            'password'=>Hash::make('123456'),
            'role'=>'shift_leader'
        ]);

        Account::create([
            'email'=>'super@test.com',
            'password'=>Hash::make('123456'),
            'role'=>'superviseur'
        ]);
    }
}