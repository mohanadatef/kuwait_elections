<?php
use Illuminate\Support\Facades\DB;
use App\Models\Social_Media\LikePost;
use Illuminate\Database\Seeder;


class LikePostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        LikePost::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 20;
        factory(LikePost::class, $count)->create();
    }
}
