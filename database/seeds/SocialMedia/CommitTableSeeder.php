<?php
use Illuminate\Support\Facades\DB;
use App\Models\Social_Media\Commit;
use Illuminate\Database\Seeder;


class CommitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Commit::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 50;
        factory(Commit::class, $count)->create();
    }
}
