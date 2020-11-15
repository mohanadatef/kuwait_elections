<?php
use Illuminate\Support\Facades\DB;
use App\Models\Core_Data\Circle;
use Illuminate\Database\Seeder;


class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Circle::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 20;
        factory(Circle::class, $count)->create();
    }
}
