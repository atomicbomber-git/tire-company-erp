<?php

use App\Customer;
use App\SalesOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesOrderSeeder extends Seeder
{
    const N_TO_BE_SEEDED = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();

        for ($i = 0; $i < static::N_TO_BE_SEEDED; ++$i) {
            $sold_at = now()->subDays(rand(0, 90));
            $to_be_paid_before = $sold_at->clone()->addMonths(3);

            $sales_order = SalesOrder::query()->create([
                "customer_id" => Customer::query()->inRandomOrder()->value("id"),
                "sold_at" => $sold_at,
                "to_be_paid_before" => $to_be_paid_before,
                "is_paid" => false,
            ]);

            $items = \App\Item::query()->inRandomOrder()
                ->limit(rand(2, 10))
                ->get();

            $items->each(function (\App\Item $item) use ($sales_order) {
                \App\SalesOrderItem::query()->forceCreate([
                    "sales_order_id" => $sales_order->id,
                    "item_id" => $item->id,
                    "quantity" => rand(1, 10),
                    "price" => rand(1, 20) * 50_000,
                ]);
            });
        }

        DB::commit();
    }
}
