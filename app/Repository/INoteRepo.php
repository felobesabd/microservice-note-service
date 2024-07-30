<?php


namespace App\Repository;


interface INoteRepo
{
    public function getUserNotes($userId);

    public function getUserNote($noteId, $userId);

    public function create($data);

    public function update($noteId, $userId, $data);

    public function delete($noteId, $userId);
}
