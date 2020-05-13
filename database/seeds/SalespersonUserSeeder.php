<?php

use App\Salesperson;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SalespersonUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        $user = factory(User::class)->create([
            "name" => "salesman",
            "username" => "salesman",
            "password" => Hash::make("salesman"),
            "type" => \App\Constants\UserType::SALESPERSON,
        ]);

        Salesperson::query()->forceCreate([
            "user_id" => $user->id,
        ]);

        DB::commit();
    }
}
