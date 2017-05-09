<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create();
        factory(App\User::class)->create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => App\User::ROLE_ADMIN
        ]);
        factory(App\User::class)->create([
            'username' => 'adrian',
            'password' => bcrypt('adrian'),
            'role' => App\User::ROLE_USER
        ]);
    }
}
