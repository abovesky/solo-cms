<?php

namespace app\api\model;

use think\model\concern\SoftDelete;

class Book extends BaseModel
{
    use SoftDelete;

    protected $deleteTime = 'delete_time';
    protected $autoWriteTimestamp = 'datetime';

}