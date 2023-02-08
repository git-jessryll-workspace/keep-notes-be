<?php

namespace App\Services\Folders;

use App\Repositories\FolderRepository;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\TaggableId;
use App\Repositories\Pipelines\QueryFilters\TaggableType;
use App\Repositories\TagRepository;

class DeleteFolderService
{
    /**
     * @var FolderRepository
     */
    private FolderRepository $folderRepository;

    /**
     * @var TagRepository
     */
    private TagRepository $tagRepository;

    /**
     * @param FolderRepository $folderRepository
     * @param TagRepository $tagRepository
     */
    public function __construct(FolderRepository $folderRepository, TagRepository $tagRepository)
    {
        $this->folderRepository = $folderRepository;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param int $id
     * @return string[]
     */
    public function delete(int $id): array
    {
        $this->folderRepository->delete($id);
        request()['taggable_id'] = $id;
        request()['taggable_type'] = "FOLDER";
        (new PipelineQuery(
            $this->tagRepository->model(), [
            TaggableId::class,
            TaggableType::class
        ]))->pipes()->update([
            'taggable_id' => null,
            'taggable_type' => null
        ]);

        return [
            'message' => 'Folder deleted'
        ];
    }
}
