<?php

namespace App\Services\FolderNotes;

use App\Repositories\FolderNoteRepository;

class CreateFolderNoteService
{
    private FolderNoteRepository $folderNoteRepository;

    /**
     * @param FolderNoteRepository $folderNoteRepository
     */
    public function __construct(FolderNoteRepository $folderNoteRepository)
    {
        $this->folderNoteRepository = $folderNoteRepository;
    }

    public function create(array $payload)
    {
        $dateNow = now();
        $data = [
            'folder_id' => $payload['folder_id'],
            'note_id' => $payload['note_id'],
            'user_id' => auth()->id(),
            'created_at' => $dateNow,
            'updated_at' => $dateNow
        ];
        $data['id'] = $this->folderNoteRepository->create($data);
        return $data;
    }
}
