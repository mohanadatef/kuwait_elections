<?php
use Illuminate\Support\Facades\DB;
use App\Models\Core_Data\City;
use Illuminate\Database\Seeder;


class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        City::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 40;
        factory(City::class, $count)->create();
    }
}
