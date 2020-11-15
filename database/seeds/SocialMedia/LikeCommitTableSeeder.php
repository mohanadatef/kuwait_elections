<?php
use Illuminate\Support\Facades\DB;
use App\Models\Social_Media\LikeCommit;
use Illuminate\Database\Seeder;


class LikeCommitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        LikeCommit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 20;
        factory(LikeCommit::class, $count)->create();
    }
}
