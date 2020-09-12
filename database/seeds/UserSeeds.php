<?php

use Illuminate\Database\Seeder;

class UserSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'email' => 'nobita@gmail.com',
                'userName' => 'nobita',
                'codeStudent' => 'AT140000',
                'password' => bcrypt('nobita'),
                'role'=> 'admin',
                'status' => USER_ACTIVE,
                'created_at' => '2020-07-19 12:42:22'
            ],
            [
                'id' => 2,
                'email' => 'doremon@gmail.com',
                'userName' => 'doremon',
                'codeStudent' => 'AT140001',
                'password' => bcrypt('doremon'),
                'role'=> 'admin',
                'status' => USER_ACTIVE,
                'created_at' => '2020-07-19 12:42:22'
            ],
            [
                'id' => 3,
                'email' => 'xuka@gmail.com',
                'userName' => 'xuka_chan',
                'codeStudent' => 'AT140002',
                'password' => bcrypt('xuka'),
                'role'=> 'admin',
                'status' => USER_ACTIVE,
                'created_at' => '2020-07-19 12:42:22'
            ],
            [
                'id' => 4,
                'email' => 'dulh181199@gmail.com',
                'userName' => 'dusainbolt',
                'codeStudent' => 'AT140509',
                'password' => bcrypt('anhdu999'),
                'role'=> 'user',
                'status' => USER_ACTIVE,
                'created_at' => '2020-07-19 12:42:22'
            ],
        ];
        \App\User::insert($data);
    }
}
