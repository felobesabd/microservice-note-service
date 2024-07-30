<?php


namespace App\Service;


interface INoteService
{
    public function getUserNotes($userId);

    public function getUserNote($noteId, $userId);

    public function createNote($data);

    public function updateNote($noteId, $userId, $data);

    public function deleteNote($noteId, $userId);
}
