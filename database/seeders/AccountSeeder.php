<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountInformation;
use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = Account::factory(20)->
            has(AccountInformation::factory(1))->
            has(Address::factory(1)->default())->
            create();

        $accounts->each(function ($account) {
            $random_number = rand(0, 5);
            $account->Address()->saveMany(Address::factory($random_number)->make());
        });

    }
}
