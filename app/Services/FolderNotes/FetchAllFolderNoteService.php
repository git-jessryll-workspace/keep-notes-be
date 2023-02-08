<?php

namespace App\Services\FolderNotes;

use App\Repositories\FolderNoteRepository;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\UserId;

class FetchAllFolderNoteService
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
     * @return mixed
     */
    public function all(): mixed
    {
        request()['user_id'] = auth()->id();
        $query = $this->folderNoteRepository->model()->select(['id', 'user_id', 'folder_id', 'note_id']);
        $queryClasses = [
            UserId::class
        ];
        return (new PipelineQuery($query, $queryClasses))->pipes()->get();
    }
}
