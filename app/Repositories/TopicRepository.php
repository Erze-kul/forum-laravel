<?php

namespace App\Repositories;

use App\Models\Topic;

class TopicRepository extends BaseRepository
{
    /**
     * TopicRepository constructor.
     *
     * @param Topic $model
     */
    public function __construct(Topic $model)
    {
        parent::__construct($model);
    }

}
