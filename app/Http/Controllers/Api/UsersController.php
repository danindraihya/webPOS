<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if ( !$user || !Hash::check($request->password, $user->password)) {
            return response(['status' => 404,'message' => "Not Found!!!"]);
        }

        return response(['token'=>$user->createToken('token')->plainTextToken,'status'=>'200','message'=>'Sukses']);

    }
}
