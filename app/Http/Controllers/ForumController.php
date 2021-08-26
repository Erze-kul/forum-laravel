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

    /**
     * GET topics
     */
    public function topics()
    {
        return $this->topicRepository->all();
    }

    /**
     * GET topic
     *
     * @urlParam id   int required  Идентификатор поста
     *
     */
    public function topic(int $id)
    {
        if (! $topic = $this->topicRepository->find($id)) {
            return response('Post is not exists', 404);
        }

        return $topic;
    }

    /**
     * GET topic comments
     *
     * @urlParam id   int required  Идентификатор поста
     *
     */
    public function getComments(int $id)
    {
        if (! $topic = $this->topicRepository->find($id)) {
            return response('Post is not exists', 404);
        }

        return $topic->comments()->getResults();
    }

    /**
     * DELETE topic comment
     *
     * @urlParam id   int required  Идентификатор комментария
     *
     */
    public function removeComment(int $id)
    {
        if (! $comment = $this->commentRepository->find($id)) {
            return response('Comment is not exists', 404);
        }

        $comment->delete();
        return response('');
    }

    /**
     * DELETE topic
     *
     * @urlParam id   int required  Идентификатор поста
     *
     */
    public function removeTopic(int $id)
    {
        if (! $topic = $this->topicRepository->find($id)) {
            return response('Post is not exists', 404);
        }

        $topic->delete();
        return response('');
    }

    /**
     * POST Add topic
     *
     * @bodyParam   user_id   int  required Идентификатор пользователя      Example: 1
     * @bodyParam   title    string  required    Название поста.   Example: title
     * @bodyParam   body    string  required    Тело поста.   Example: Status of work is...
     *
     */
    public function addTopic(Request $request)
    {
        if (!$user = $request->get('user_id')) {
            return response('Empty param: user_id', 400);
        }

        if (! $this->userRepository->find($user)) {
            return response('User is not exists', 404);
        }

        if (!$request->get('title')) {
            return response('Empty param: title', 400);
        }
        if (!$request->get('body')) {
            return response('Empty param: body', 400);
        }

        return $this->topicRepository->create($request->all());
    }

    /**
     * POST Add comment
     *
     * @bodyParam   user_id   int  required Идентификатор пользователя      Example: 1
     * @bodyParam   body    string  required    Тело комментария   Example: I think...
     *
     */
    public function addComment(Request $request, int $id)
    {
        if (!$user = $request->get('user_id')) {
            return response('Empty param: user_id', 400);
        }

        if (! $this->userRepository->find($user)) {
            return response('User is not exists', 404);
        }

        if (! $this->topicRepository->find($id)) {
            return response('Post is not exists', 404);
        }

        if (!$request->get('body')) {
            return response('Empty param: body', 400);
        }

        $data = array_merge($request->all(), [
            'commentable_type' => Topic::class,
            'commentable_id' => $id,
        ]);

        return $this->commentRepository->create($data);
    }
}
