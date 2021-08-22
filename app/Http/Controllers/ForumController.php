<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Repositories\CommentRepository;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ForumController extends Controller
{

    /**
     * @var TopicRepository
     */
    private $topicRepository;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        TopicRepository   $topicRepository,
        CommentRepository $commentRepository,
        UserRepository    $userRepository
    )
    {
        $this->topicRepository = $topicRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return view('forum.index', ['topics' => $this->topics()]);
    }

    public function topics()
    {
        return $this->topicRepository->all();
    }

    public function topic(int $id)
    {
        return $this->topicRepository->findOrFail($id);
    }

    public function getComments(int $id)
    {
        $topic = $this->topicRepository->findOrFail($id);;

        return $topic->comments()->getResults();
    }

    public function removeComment(int $id)
    {
        $comment = $this->commentRepository->findOrFail($id);
        $comment->delete();
    }

    public function removeTopic(int $id)
    {
        $comment = $this->topicRepository->findOrFail($id);
        $comment->delete();
    }

    public function addTopic(Request $request)
    {
        if (!$user = $request->get('user_id')) {
            return response('Empty param: user_id', 400);
        }

        $this->userRepository->findOrFail($user);

        if (!$request->get('title')) {
            return response('Empty param: title', 400);
        }
        if (!$request->get('body')) {
            return response('Empty param: body', 400);
        }

        return $this->topicRepository->create($request->all());
    }

    public function addComment(Request $request)
    {
        if (!$user = $request->get('user_id')) {
            return response('Empty param: user_id', 400);
        }

        $this->userRepository->findOrFail($user);

        if (!$topic = $request->get('commentable_id')) {
            return response('Empty param: commentable_id', 400);
        }

        $this->topicRepository->findOrFail($topic);

        if (!$request->get('body')) {
            return response('Empty param: body', 400);
        }

        $data = array_merge($request->all(), ['commentable_type' => Topic::class]);

        return $this->commentRepository->create($data);
    }
}
