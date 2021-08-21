<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class ForumController extends Controller
{

    public function index(){
        return view('forum.index', ['topics' => $this->topics()]);
    }

    public function topics(){
        return Topic::all();
    }

    public function topic(int $id)
    {
        return Topic::findOrFail($id);
    }

    public function getComments(int $id)
    {
        $topic = Topic::findOrFail($id);

        return $topic->comments ?? [];
    }

    public function removeComment(int $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }

    public function removeTopic(int $id)
    {
        $comment = Topic::findOrFail($id);
        $comment->delete();
    }

    public function addTopic(Request $request)
    {
        if (! $user = $request->get('user_id')) {
            return response('Empty param: user_id', 400);
        }

        User::findOrFail($user);

        if (! $request->get('title')) {
            return response('Empty param: title', 400);
        }
        if (! $request->get('body')) {
            return response('Empty param: body', 400);
        }

        return Topic::create($request->all());
    }

    public function addComment(Request $request)
    {
        if (! $user = $request->get('user_id')) {
            return response('Empty param: user_id', 400);
        }

        User::findOrFail($user);

        if (! $topic = $request->get('commentable_id')) {
            return response('Empty param: commentable_id', 400);
        }

        Topic::findOrFail($topic);

        if (! $request->get('body')) {
            return response('Empty param: body', 400);
        }

        $data = array_merge($request->all(), ['commentable_type' => Topic::class]);

        return Comment::create($data);
    }
}
