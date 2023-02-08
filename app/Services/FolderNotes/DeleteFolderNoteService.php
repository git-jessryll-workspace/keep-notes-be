<?php

namespace App\Services\FolderNotes;

use App\Repositories\FolderNoteRepository;

class DeleteFolderNoteService
{
    private FolderNoteRepository $folderNoteRepository;

    /**
     * @param FolderNoteRepository $folderNoteRepository
     */
    public function __construct(FolderNoteRepository $folderNoteRepository)
    {
        $this->folderNoteRepository = $folderNoteRepository;
    }

    /**
     * @param int $id
     * @return string[]
     */
    public function delete(int $id): array
    {
        $this->folderNoteRepository->delete($id);
        return [
            'message' => 'Data deleted'
        ];
    }
}
