<?php
use Illuminate\Support\Facades\DB;
use App\Models\Core_Data\Area;
use Illuminate\Database\Seeder;


class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Area::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 80;
        factory(Area::class, $count)->create();
    }
}
