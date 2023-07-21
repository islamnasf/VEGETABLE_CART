<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        User::create($this->adminData());
    }
    private function adminData(){
        return[
            'name'=>'admin',
            'phone_code'=>'+20',
           // 'email'=>'admin@yahoo.com',
            'phone'=>'11111111111',
            'role'=>'admin',
            'city'=>'cairo',
            'verify'=>'verified',
            'code_number'=>'111111',
            'password'=>Hash::make("Admin2022"),
            'email_verified_at'=>Carbon::now(),
        ];
    } 
}
