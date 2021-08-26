<?php

namespace Tests\Unit;

use App\Http\Controllers\ForumController;
use App\Models\Comment;
use App\Models\Topic;
use App\Models\User;
use App\Repositories\CommentRepository;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Tests\TestCase;

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

    /**
     * @var Topic
     */
    private $topic;

    /**
     * @var Comment
     */
    private $comment;


    public function __construct()
    {
        parent::__construct();
        $this->setUp();

        $this->userRepository = $this->createMock(UserRepository::class);
        $this->topicRepository = $this->createMock(TopicRepository::class);
        $this->commentRepository = $this->createMock(CommentRepository::class);

        $this->controller = new ForumController($this->topicRepository, $this->commentRepository, $this->userRepository);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $faker = \Faker\Factory::create('ru_RU');
        $this->topic = Topic::create(
            [
                'title' => $faker->sentence(5),
                'body' => $faker->realText(),
                'user_id' => mt_rand(1, 15),
            ]
        );
        $this->comment = Comment::create(
            [
                'body' => '',
                'commentable_id' => $this->topic->id,
                'commentable_type' => Topic::class,
                'user_id' => mt_rand(1, 15),
            ]
        );
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

        $this->topicRepository->method('find')->willReturn($result);
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
        $this->topicRepository->method('find')->willReturn($topic);

        $this->assertEquals($result, $this->controller->getComments(1));
    }

    public function testRemoveTopic()
    {
        self::assertNotNull(Topic::find($this->topic->id));
        $this->topicRepository->method('find')->willReturn($this->topic);
        $this->controller->removeTopic($this->topic->id);
        self::assertNull(Topic::find($this->topic->id));
    }

    public function testRemoveComment()
    {
        self::assertNotNull(Comment::find($this->comment->id));
        $this->commentRepository->method('find')->willReturn($this->comment);
        $this->controller->removeComment($this->comment->id);
        self::assertNull(Comment::find($this->comment->id));
    }

    public function testAddTopic()
    {
        $r = new Request([
            'user_id' => 1,
            'title' => 'title',
            'body' => 'body',
        ]);

        $user = $this->createMock(User::class);
        $this->userRepository->method('find')->willReturn($user);
        $this->topicRepository->expects(self::once())->method('create')->willReturn($this->topic);
        $result = $this->controller->addTopic($r);
        self::assertEquals($this->topic, $result);
    }

    public function testAddComment()
    {
        $r = new Request([
            'user_id' => 1,
            'body' => 'body',
        ]);

        $user = $this->createMock(User::class);
        $this->userRepository->method('find')->willReturn($user);
        $this->topicRepository->method('find')->willReturn($this->topic);
        $this->commentRepository->expects(self::once())->method('create')->willReturn($this->comment);
        $result = $this->controller->addComment($r, 1);
        self::assertEquals($this->comment, $result);
    }


}
