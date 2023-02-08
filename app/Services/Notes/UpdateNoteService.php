<?php

namespace App\Services\Notes;

use App\Repositories\NoteRepository;

class UpdateNoteService
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
     * @param array $payload
     * @return array
     */
    public function update(int $id, array $payload): array
    {
        $data = [
            'title' => $payload['title'],
            'body' => $payload['body'],
            'updated_at' => now()
        ];
        $this->repository->update($id, $data);
        $data['id'] = $id;
        return $data;
    }
}
