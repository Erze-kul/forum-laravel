<?php

namespace Tests\Unit;

use App\Http\Controllers\ForumController;
use App\Models\Topic;
use App\Repositories\CommentRepository;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class ForumControllerTest extends TestCase
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

    /**
     * @var ForumController
     */
    private $controller;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->topicRepository = $this->createMock(TopicRepository::class);
        $this->commentRepository = $this->createMock(CommentRepository::class);

        $this->controller = new ForumController($this->topicRepository, $this->commentRepository, $this->userRepository);
    }

    public function testEmptyTopics()
    {
        $result = new Collection();
        $this->topicRepository->method('all')->willReturn($result);

        $this->assertEquals($result, $this->controller->topics());
    }


    public function testTopics()
    {
        $result = new Collection(
            [
                "id" => 8,
                "title" => "test",
                "body" => "111111111111111111111111",
                "user_id" => 2,
                "created_at" => "2021-08-21T13:45:48.000000Z",
                "updated_at" => "2021-08-21T13:45:48.000000Z"
            ]
        );

        $this->topicRepository->method('all')->willReturn($result);

        $this->assertEquals($result, $this->controller->topics());
    }

    public function testTopic()
    {
        $result = new Topic(
            [
                "id" => 8,
                "title" => "test",
                "body" => "111111111111111111111111",
                "user_id" => 2,
                "created_at" => "2021-08-21T13:45:48.000000Z",
                "updated_at" => "2021-08-21T13:45:48.000000Z"
            ]
        );

        $this->topicRepository->method('findOrFail')->willReturn($result);
        $this->assertEquals($result, $this->controller->topic(8));
    }

    public function testGetComments()
    {
        $relations = $this->createMock(MorphMany::class);

        $result =
            [
                ["id" => 6,
                    "body" => "Duchess, the Duchess! Oh!.",
                    "commentable_id" => 2,
                    "commentable_type" => "App\\Models\\Topic",
                    "user_id" => 15,
                    "created_at" => "2021-08-15T09:22:06.000000Z",
                    "updated_at" => "2021-08-15T09:22:06.000000Z"
                ],
                [
                    "id" => 91,
                    "body" => "Duchess, the Duchess! Oh!.",
                    "commentable_id" => 3,
                    "commentable_type" => "App\\Models\\Topic",
                    "user_id" => 15,
                    "created_at" => "2021-09-15T09:22:06.000000Z",
                    "updated_at" => "2021-09-15T09:22:06.000000Z"
                ]
            ];

        $relations->method('getResults')->willReturn($result);
        $topic = $this->createMock(Topic::class);
        $topic->method('comments')->willReturn($relations);
        $this->topicRepository->method('findOrFail')->willReturn($topic);

        $this->assertEquals($result, $this->controller->getComments(1));
    }

}
