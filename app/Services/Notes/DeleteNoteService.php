<?php

namespace App\Services\Notes;

use App\Repositories\NoteRepository;
use Illuminate\Validation\ValidationException;

class DeleteNoteService
{
    /**
     * @var NoteRepository
     */
    private NoteRepository $repository;

    /**
     * @param NoteRepository $repository
     */
    public function __construct(NoteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return string[]
     * @throws ValidationException
     */
    public function delete(int $id): array
    {
        $note = $this->repository->findById($id, ['id', 'user_id']);
        if ($note->user_id !== auth()->id()) {
            throw ValidationException::withMessages([
                'error_message' => "Not authorize"
            ]);
        }
        $this->repository->delete($id);
        $note->delete();
        return [
            'message' => 'Data deleted'
        ];
    }
}
