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
        $this->call([
            UserSeeder::class,
            DistrictSeeder::class,
        ]);
        $markets = ['bara bazar', 'bawngkawn bazar', 'thakthing bazar', 'ramhlun bazar'];
        $locations = ['dawrpui', 'bawngkawn', 'mission veng', 'ramhlun north'];
        $items = ['antam', 'alu', 'mai an', 'zikhlum'];
        foreach ($markets as $key => $market) {
            Market::create([
                'name' => $market,
                'location' => $locations[$key],
                'district_id' => 1,
            ]);
        }
        foreach ($items as $item) {
            Item::create(['name' => $item]);
        }
    }
}
