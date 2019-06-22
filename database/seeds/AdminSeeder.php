<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // db query builder
        DB::table('admins')->insert([
           'name'=>'sharukh khan',
            'email'=>'srk@gmail.com',
            'password'=>Hash::make('123456'),
            'active'=>1,
            'role'=>'master-admin'
        ]);

        // eloquent model
//        $admin = new Admin();
//        $admin->name='sharukh khan';
//        $admin->email='srk@gmail.com';
//        $admin->password=Hash::make('123456');
//        $admin->active=1;
//        $admin->role='master-admin';
//        $admin->save();
    }
}
