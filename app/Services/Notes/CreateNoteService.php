<?php

namespace App\Services\Notes;

use App\Repositories\NoteRepository;

class CreateNoteService
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
     * @param array $payload
     * @return array
     */
    public function create(array $payload): array
    {
        $dateNow = now();
        $data = [
            'title' => $payload['title'],
            'body' => $payload['body'],
            'user_id' => auth()->id(),
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
        ];
        $data['id'] = $this->repository->create($data);
        return $data;
    }
}
