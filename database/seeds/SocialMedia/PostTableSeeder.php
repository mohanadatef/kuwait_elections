<?php
use Illuminate\Support\Facades\DB;
use App\Models\Social_Media\Post;
use Illuminate\Database\Seeder;


class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Post::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $count = 20;
        factory(Post::class, $count)->create();
    }
}
