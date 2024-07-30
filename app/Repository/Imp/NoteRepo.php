<?php


namespace App\Repository\Imp;


use App\Models\Note;
use App\Repository\INoteRepo;

class NoteRepo implements INoteRepo
{
    public function getUserNotes($userId)
    {
        return Note::where('user_id', $userId)->get();
    }

    public function getUserNote($noteId, $userId)
    {
        return $note = Note::where('user_id', $userId)->where('id', $noteId)->first();
    }

    public function getUserNotesCount($userId)
    {
        return $notes = Note::where('user_id', $userId)->count();
    }

    public function create($data)
    {
        return Note::create($data);
    }

    public function update($noteId, $userId, $data)
    {
        $note = $this->getUserNote($noteId, $userId);
        $note->update($data);
        return $note;
    }

    public function delete($noteId, $userId)
    {
        $note = $this->getUserNote($noteId, $userId);
        $note->destroy($noteId);
        return $note;
    }
}
