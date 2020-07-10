<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\User as UserResource;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();

        var_dump(hash($users->password));
        return UserResource::collection($users);
    }
}
