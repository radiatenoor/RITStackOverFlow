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
        //$this->call(MetaData::class);
//        for($i=0;$i<20;$i++) {
//            DB::table('question_tags')->insert([
//                'question_id' => rand(50, 69),
//                'tag_id' => rand(1, 3),
//                'created_at' => date('Y-m-d h:i:s'),
//                'updated_at' => date('Y-m-d h:i:s'),
//            ]);
//        }

        //$this->call(AdminSeeder::class);
        $this->call(PermissionSeeder::class);
    }
}
