<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\CommentRepository;
use App\Repositories\TopicRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class ForumProvider extends ServiceProvider
{

    public function register()
    {
        parent::register();

        $this->app->bind(BaseRepository::class, BaseRepository::class);
        $this->app->bind(TopicRepository::class, TopicRepository::class);
        $this->app->bind(CommentRepository::class, CommentRepository::class);
        $this->app->bind(UserRepository::class, UserRepository::class);
    }
}
