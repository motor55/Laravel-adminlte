<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default user
        $user = User::create([
            'name' => 'admin',
            'email' => 'test@tt.tt',
            'password' => bcrypt('111'),
            'avatar' => 'avatar.svg'
        ]);

        // Generate avatar to defautl user
        $avatar = \Avatar::create('admin')->setFontFamily('sans-serif')->toSvg();
        Storage::disk('public')->put('avatars/'.$user->id.'/avatar.svg', (string) $avatar);
    }
}
