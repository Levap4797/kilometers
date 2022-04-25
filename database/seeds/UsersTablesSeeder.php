<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'    => 'Pavel',
            'email'    => 'pavelpavlov4797@gmail.com',
            'password'   =>  Hash::make('12345678'),
            'remember_token' =>  Str::random(10),
            'role' =>  Role::where('name', Role::ROLE_ADMIN)->firstOrfail()->id,
        ]);
    }
}
