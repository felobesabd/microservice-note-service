<?php


namespace App\Redis;


interface IRedisPubSub
{
    public function publish($topic, $data);
    public function subscribe($topics, $functions);
}
