<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * GET users
     */
    public function users()
    {
        return User::all();
    }
}
