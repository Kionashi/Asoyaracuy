<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DemoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User
        $user = new User();
        $user->id = 1;
        $user->enabled = true;
        $user->email = "choroni@mail.com";
        $user->house = "Choroni";
        $user->balance = 0;
        $user->password = "7c4a8d09ca3762af61e59520943dc26494f8941b";
        $user->phone = "02122381434";
        $user->register_date = '2018-04-05 19:04:41';
        $user->register_ip_address = '192.168.0.1';
        $user->status = UserStatus::ACTIVE;
        $user->save();
    }
}
