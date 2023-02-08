<?php

namespace App\Services\Notes;

use App\Repositories\NoteRepository;
use Illuminate\Validation\ValidationException;

class ShowNoteService
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
     * @return object
     * @throws ValidationException
     */
    public function show(int $id): object
    {
        $note = $this->repository->findById($id);
        if (!$note) {
            throw ValidationException::withMessages([
                'error_message' => "Data not found"
            ])->status(404);
        }
        return $note;
    }
}
