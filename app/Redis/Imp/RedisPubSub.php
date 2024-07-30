<?php


namespace App\Redis\Imp;

use App\Redis\IRedisPubSub;
use Illuminate\Support\Facades\Redis;
use Predis\Client;

class RedisPubSub implements IRedisPubSub
{
    public function publish($topic, $data)
    {
        $redisPrefix = env('REDIS_PREFIX');

        $publisher = new Client([
            "host" => env('REDIS_HOST'),
            "password" => env('REDIS_PASSWORD'),
            "port" => env("REDIS_PORT"),
        ]);

        $publisher->publish(
            $redisPrefix.$topic,
            json_encode($data)
        );
    }

    public function subscribe($topics, $functions)
    {
        // edit redis connection subscriber in config database.php
        $redis = Redis::connection('subscriber');

        $publisher = new Client([
            "host" => env('REDIS_HOST'),
            "password" => env('REDIS_PASSWORD'),
            "port" => env("REDIS_PORT"),
        ]);

        $redis->subscribe($topics, function ($message) use ($publisher, $functions) {
            $message = json_decode($message);
            var_dump('message for notes', $message);
            if ($message->type == 'user_registered') {
                $functions['userRegistered']($message, $publisher);
            }
        });
    }
}
