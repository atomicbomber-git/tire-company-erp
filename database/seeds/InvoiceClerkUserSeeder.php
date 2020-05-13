<?php

use App\Salesperson;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InvoiceClerkUserSeeder extends Seeder
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
            "name" => "Fakturis 01",
            "username" => "fakturis",
            "password" => Hash::make("fakturis"),
            "type" => \App\Constants\UserType::INVOICE_CLERK,
        ]);

        DB::commit();
    }
}
