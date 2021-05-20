<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EntriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $initial_entries = [
            [
                'label' => 'Initial balance',
                'amount' => 2000,
                'date' => Carbon::now()->subDays(5),
            ],
            [
                'label' => 'Groceries',
                'amount' => -5,
                'date' => Carbon::now()->subDays(3),
            ],
            [
                'label' => 'Gas',
                'amount' => -25,
                'date' => Carbon::now()->subDays(3),
            ],
            [
                'label' => 'Netflix subscription',
                'amount' => 10,
                'date' => Carbon::now()->subDays(1),
            ],
            [
                'label' => 'Credit card payment',
                'amount' => -150,
                'date' => Carbon::now(),
            ],
            [
                'label' => 'Unexpected income',
                'amount' => 50,
                'date' => Carbon::now(),
            ],
        ];

        $user->entries()->createMany($initial_entries);
    }
}
