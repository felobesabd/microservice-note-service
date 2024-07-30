<?php


namespace App\Service\Imp;

use App\Redis\Imp\RedisPubSub;
use App\Service\INoteService;
use App\Repository\INoteRepo;

class NoteService implements INoteService
{
    protected INoteRepo $noteRepo;
    public RedisPubSub $redisPubSub;

    public function __construct(INoteRepo $noteRepo, RedisPubSub $redisPubSub)
    {
        $this->redisPubSub = $redisPubSub;
        $this->noteRepo = $noteRepo;
    }

    public function getUserNotes($userId)
    {
        return $notes = $this->noteRepo->getUserNotes($userId);
    }

    public function getUserNote($noteId, $userId)
    {
        return $notes = $this->noteRepo->getUserNote($noteId, $userId);
    }

    public function createNote($data)
    {
        $note = $this->noteRepo->create($data);

        $count = $this->noteRepo->getUserNotesCount($note->user_id);

        $this->redisPubSub->publish('user_added_note', [
            'type' => 'user_added_note',
            'note_id' => $note->id,
            'user_id' => $note->user_id,
            'title' => $note->title,
            'notes_count' => $count,
        ]);

        return $note;
    }

    public function updateNote($noteId, $userId, $data)
    {
        return $notes = $this->noteRepo->update($noteId, $userId, $data);
    }

    public function deleteNote($noteId, $userId)
    {
        return $notes = $this->noteRepo->delete($noteId, $userId);
    }

    public function createWelcomeNoteForRegisteredUser($data)
    {
        $data['title'] = "welcome to our notes app";
        $data['content'] = 'terms and permissions';

        return $this->noteRepo->create($data);
    }
}
