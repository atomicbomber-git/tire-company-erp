<?php

use App\Item;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    const PREFIX = "BAN ";
    const N_TO_BE_SEEDED = 100;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        for ($i = 0; $i < static::N_TO_BE_SEEDED; ++$i) {
            Item::query()->forceCreate([
                "name" =>  static::PREFIX . $i,
            ]);
        }

        DB::commit();
    }
}
