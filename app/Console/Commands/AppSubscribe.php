<?php

namespace App\Console\Commands;

use App\Redis\IRedisPubSub;
use App\Service\Imp\NoteService;
use Illuminate\Console\Command;

class  AppSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

    public IRedisPubSub $redisPubSubscriber;
    public NoteService $noteService;

    public function __construct(
        IRedisPubSub $redisPubSubscriber,
        NoteService $noteService
    )
    {
        parent::__construct();
        $this->redisPubSubscriber = $redisPubSubscriber;
        $this->noteService = $noteService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscribeList = ['user_registered',];
        $subscribeCallbacks = [];

        $subscribeCallbacks['userRegistered'] = function ($message, $publisher) {
            var_dump('message command sub notes', $message);
            $data['user_id'] = $message->user_id;
            $this->noteService->createWelcomeNoteForRegisteredUser($data);
        };

        $this->redisPubSubscriber->subscribe($subscribeList, $subscribeCallbacks);
    }
}
