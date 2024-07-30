<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNoteRequest;
use App\Service\INoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected INoteService $noteService;

    protected  int $user_id;

    public function __construct(INoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index(Request $request)
    {
        $userId = $request->headers->get('user_id');
        $note = $this->noteService->getUserNotes($userId);
        return response()->json(['data'=> $note, 'msg' => 'success', 'code' => 201]);
    }

    public function get($noteId, Request $request)
    {
        $userId = $request->headers->get('user_id');

        $note = $this->noteService->getUserNote($noteId, $userId);
        return response()->json(['data'=> $note, 'msg' => 'success', 'code' => 201]);
    }

    public function create(CreateNoteRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] =    $this->getUserId($request);
        $note = $this->noteService->createNote($data);
        return response()->json(['data'=> $note, 'msg' => 'success', 'code' => 201]);
    }

    public function update($noteId, Request $request)
    {

        $data = $request->all();
        $userId =  $this->getUserId($request);

        $note = $this->noteService->updateNote($noteId, $userId, $data);
        return response()->json(['data'=> $note, 'msg' => 'success', 'code' => 201]);
    }

    public function delete($noteId, Request $request)
    {
        $userId = $request->user_id;
        $this->noteService->deleteNote($noteId, $userId);

        return response()->json(['data'=> [], 'msg' => 'success', 'code' => 200]);
    }

    private function  getUserId(Request $request)
    {
        return $this->user_id =  $request->headers->get('user_id');
    }
}
