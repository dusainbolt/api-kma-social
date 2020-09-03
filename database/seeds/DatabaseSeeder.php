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
        $this->call(UserSeeds::class);
        $this->call(MessageSeed::class);
        $this->call(UserInfoSeed::class);
    }
}