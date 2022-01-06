<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Item;
use App\Models\Market;
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
        \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create(['email' => 'awma@gmail.com', 'role' => 'admin']);
        $dist = District::create();
        $markets = ['bara bazar', 'bawngkawn bazar', 'thakthing bazar', 'ramhlun bazar'];
        $locations = ['dawrpui', 'bawngkawn', 'mission veng', 'ramhlun north'];
        $items = ['antam', 'alu', 'mai an', 'zikhlum'];
        foreach ($markets as $key => $market) {
            Market::create([
                'name' => $market,
                'location' => $locations[$key],
                'district_id' => $dist->id,
            ]);
        }
        foreach ($items as $item) {
            Item::create(['name' => $item]);
        }
    }
}
