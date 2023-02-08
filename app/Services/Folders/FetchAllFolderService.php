<?php

namespace App\Services\Folders;

use App\Repositories\FolderNoteRepository;
use App\Repositories\FolderRepository;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\UserId;
use App\Repositories\Pipelines\QueryWhereIn\FolderIds;

class FetchAllFolderService
{
    /**
     * @var FolderRepository
     */
    private FolderRepository $folderRepository;

    /**
     * @var FolderNoteRepository
     */
    private FolderNoteRepository $folderNoteRepository;

    /**
     * @param FolderRepository $folderRepository
     * @param FolderNoteRepository $folderNoteRepository
     */
    public function __construct(FolderRepository $folderRepository, FolderNoteRepository $folderNoteRepository)
    {
        $this->folderRepository = $folderRepository;
        $this->folderNoteRepository = $folderNoteRepository;
    }

    /**
     * @return mixed
     */
    public function all(): mixed
    {
        $folderIds = [];

        $folderQuery = $this->folderRepository->model()
            ->select(['folders.name', 'folders.id']);

        $folderQueryClasses = [
            UserId::class
        ];

        $folders = (new PipelineQuery($folderQuery, $folderQueryClasses))
            ->pipes()
            ->get();

        foreach ($folders as $folder) {
            $folderIds[] = $folder->id;
        }

        request()['folder_ids'] = $folderIds;
        $folderNoteQuery = $this->folderNoteRepository->model()->select(['folder_notes.id', 'folder_notes.folder_id', 'folder_notes.note_id']);
        $folderNoteQueryClasses = [FolderIds::class];
        $folderNotes = (new PipelineQuery($folderNoteQuery, $folderNoteQueryClasses))
            ->pipes()
            ->get();

        foreach ($folders as $folder) {
            $list = [];
            foreach ($folderNotes as $folderNote) {
                if ($folder->id === $folderNote->folder_id) {
                    $list[] = $folderNote;
                }
            }
            $folder->folder_notes = $list;
        }
        return $folders;
    }
}
