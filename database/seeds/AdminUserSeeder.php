<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            "name" => "Administrator",
            "username" => "admin",
            "password" => Hash::make("admin"),
            "type" => \App\Constants\UserType::ADMINISTRATOR,
        ]);
    }
}
