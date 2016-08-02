<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
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
                'first_name'        => 'Admin',
                'last_name'         => 'User',
                'nickname'          => 'Admin',
                'email'             => 'admin@gmail.com',
                'password'          => 'P@ssw0rd2016!',
                'status'            => 'Active',

              
            ],
            [
                'first_name'        => 'Standard',
                'last_name'         => 'User',
                'nickname'          => 'Standard',
                'email'             => 'standard@gmail.com',
                'password'          => 'P@ssw0rd2016!',
                'status'            => 'InActive',
            ]
        ];
        foreach ($data as $key)
        {
            DB::table('users')->insert([
                'first_name'    => $key['first_name'],
                'last_name'     => $key['last_name'],
                'email'         => $key['email'],
                'password'      => bcrypt($key['password']),
                'status'        => $key['status'],
            ]);


        }
    }
}
