<?php

use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 所有用户
        $allUsers = \App\Models\User::all();
        // 第一个用户
        $user = $allUsers->first();
        $others = $allUsers->slice(1);

        $user->follow($others->pluck('id')->toArray());

        foreach ($others as $other) {
            $other->follow($user->id);
        }
    }
}
