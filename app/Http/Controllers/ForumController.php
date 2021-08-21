<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class ForumController extends Controller
{

    public function index(){
        return view('forum.index', ['topics' => Topic::all()]);
    }
}
