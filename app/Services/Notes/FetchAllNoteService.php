<?php

namespace App\Services\Notes;

use App\Repositories\FolderNoteRepository;
use App\Repositories\NoteRepository;
use App\Repositories\Pipelines\PipelineQuery;
use App\Repositories\Pipelines\QueryFilters\TaggableType;
use App\Repositories\Pipelines\QueryFilters\UserId;
use App\Repositories\Pipelines\QueryWhereIn\NoteIds;
use App\Repositories\Pipelines\QueryWhereIn\TaggableIds;
use App\Repositories\TagRepository;

class FetchAllNoteService
{
    /**
     * @var NoteRepository
     */
    protected NoteRepository $repository;

    /**
     * @var TagRepository
     */
    protected TagRepository $tagRepository;

    /**
     * @var FolderNoteRepository
     */
    protected FolderNoteRepository $folderNoteRepository;


    /**
     * @param NoteRepository $repository
     * @param TagRepository $tagRepository
     * @param FolderNoteRepository $folderNoteRepository
     */
    public function __construct(NoteRepository $repository, TagRepository $tagRepository, FolderNoteRepository $folderNoteRepository)
    {
        $this->repository = $repository;
        $this->tagRepository = $tagRepository;
        $this->folderNoteRepository = $folderNoteRepository;
    }


    /**
     * @return mixed
     */
    public function all(): mixed
    {
        request()['user_id'] = auth()->id();
        request()['taggable_type'] = "NOTE";

        $notes = (new PipelineQuery(
            $this->repository->model()->select(['id', 'title', 'body', 'updated_at']),
            [UserId::class]
        ))->pipes()->get();

        $noteIds = [];
        foreach ($notes as $note) {
            $noteIds[] = $note->id;
        }

        request()['taggable_ids'] = $noteIds;
        request()['note_ids'] = $noteIds;

        $tags = (new PipelineQuery(
            $this->tagRepository->model()->select(['id', 'label', 'taggable_id']),
            [
                TaggableIds::class,
                TaggableType::class
            ]
        ))->pipes()->get();

        $folderNotes = (new PipelineQuery(
            $this->folderNoteRepository->model()->select(['id', 'folder_id', 'note_id']),
            [
                UserId::class,
                NoteIds::class
            ]
        ))->pipes()->get();

        foreach ($notes as $note) {
            $noteTags = $tags->where('taggable_id', $note->id);
            $tagList = [];
            foreach ($noteTags as $tag) {
                $tagList[] = $tag;
            }
            $note->tags = $tagList;
            $note->folder = $folderNotes->where('note_id', $note->id)->first();
        }

        return $notes;
    }
}
