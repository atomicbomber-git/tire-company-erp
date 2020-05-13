<?php

use App\Customer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminUserSeeder::class);
         $this->call(CustomerSeeder::class);
         $this->call(ItemSeeder::class);
    }
}
