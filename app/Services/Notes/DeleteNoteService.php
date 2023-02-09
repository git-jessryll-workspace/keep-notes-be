<?php

namespace App\Services\Notes;

use App\Repositories\FavoriteRepository;
use App\Repositories\FolderNoteRepository;
use App\Repositories\NoteRepository;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\FavorableId;
use App\Repositories\Pipelines\QueryFilters\FavorableType;
use App\Repositories\Pipelines\QueryFilters\NoteId;
use App\Repositories\Pipelines\QueryFilters\TaggableId;
use App\Repositories\Pipelines\QueryFilters\TaggableType;
use App\Repositories\Pipelines\QueryFilters\UserId;
use App\Repositories\TagRepository;
use Illuminate\Validation\ValidationException;

class DeleteNoteService
{
    /**
     * @var NoteRepository
     */
    private NoteRepository $repository;
    /**
     * @var FolderNoteRepository
     */
    private FolderNoteRepository $folderNoteRepository;
    /**
     * @var TagRepository
     */
    private TagRepository $tagRepository;
    /**
     * @var FavoriteRepository
     */
    private FavoriteRepository $favoriteRepository;

    /**
     * @param NoteRepository $repository
     * @param FolderNoteRepository $folderNoteRepository
     * @param TagRepository $tagRepository
     * @param FavoriteRepository $favoriteRepository
     */
    public function __construct(NoteRepository $repository, FolderNoteRepository $folderNoteRepository, TagRepository $tagRepository, FavoriteRepository $favoriteRepository)
    {
        $this->repository = $repository;
        $this->folderNoteRepository = $folderNoteRepository;
        $this->tagRepository = $tagRepository;
        $this->favoriteRepository = $favoriteRepository;
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

        request()['user_id'] = auth()->id();
        request()['note_id'] = $id;
        request()['taggable_id'] = $id;
        request()['taggable_type'] = 'NOTE';
        request()['favorable_id'] = $id;
        request()['favorable_type'] = 'NOTE';
        (new PipelineQuery(
            $this->folderNoteRepository->model(),
            [UserId::class, NoteId::class]
        ))->pipes()->delete();
        (new PipelineQuery($this->tagRepository->model(), [
            TaggableId::class,
            TaggableType::class
        ]))->pipes()->delete();
        (new PipelineQuery(
            $this->favoriteRepository->model(),
            [
                FavorableId::class,
                FavorableType::class
            ]
        ))->pipes()->delete();
        $this->repository->delete($id);
        return [
            'message' => 'Data deleted'
        ];
    }
}
