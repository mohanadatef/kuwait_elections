<?php

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
        //ACL
        $this->call(PermissionTableSeeder::class);

        //CoreData
        //$this->call(CountryTableSeeder::class);
        //$this->call(CityTableSeeder::class);
        //$this->call(AreaTableSeeder::class);

        //SocialMedia
        //$this->call(PostTableSeeder::class);
        //$this->call(LikePostTableSeeder::class);
        //$this->call(CommitTableSeeder::class);
        //$this->call(LikeCommitTableSeeder::class);
    }
}
