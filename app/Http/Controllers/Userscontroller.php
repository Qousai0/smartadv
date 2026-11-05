<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Userscontroller extends Controller
{
    function createuser() {
        $user = User::create(
            [
                'name' => 'qousai hassسan',
                'email' => 'qousai@example.com',
                'password' => bcrypt('password'),

            ]
        );
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

}
