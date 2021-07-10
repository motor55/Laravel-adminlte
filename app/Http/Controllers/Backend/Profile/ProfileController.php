<?php

namespace App\Http\Controllers\Backend\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Upload;
use App\Models\User;
use Avatar;

class ProfileController extends Controller
{
    public function getAuthUser ()
    {
        return Auth::user();
    }

    public function updateAuthUser (Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.Auth::id()
        ]);

        $user = User::find(Auth::id());

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $avatar = \Avatar::create('admin')->setFontFamily('sans-serif')->toSvg();
        Storage::put('public/avatars/'.$user->id.'/avatar.svg', (string) $avatar);

        return $user;
    }

    public function updatePasswordAuthUser(Request $request)
    {
        $this->validate($request, [
            'current' => 'required|string',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return $user;
    }

    public function uploadAvatarAuthUser(Request $request)
    {
        $upload = new Upload();
        $avatar = $upload->upload($request->file, 'public/avatars/'.Auth::id(), 'avatar')->resize(200, 200)->getData();

        $user = User::find(Auth::id());
        $user->avatar = $avatar['basename'];
        $user->save();

        return $user;
    }

    public function removeAvatarAuthUser()
    {
        $user = User::find(Auth::id());
        $user->avatar = 'avatar.svg';
        $user->save();

        return $user;
    }
}
