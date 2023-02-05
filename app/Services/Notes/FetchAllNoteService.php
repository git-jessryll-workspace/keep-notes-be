<?php

namespace App\Services\Notes;

use App\Repositories\FolderNoteRepository;
use App\Repositories\NoteRepository;
use App\Repositories\TagRepository;

class FetchAllNoteService
{
    protected NoteRepository $repository;
    protected TagRepository $tagRepository;
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

    public function all()
    {
        request()['user_id'] = auth()->id();

        request()['taggable_type'] = "NOTE";
        $notes = $this->repository->findAll();
        $noteIds = [];
        foreach ($notes as $note) {
            $noteIds[] = $note->id;
        }
        request()['taggable_ids'] = $noteIds;
        $tags = $this->tagRepository->findAll();
        $folderNotes = $this->folderNoteRepository->findAll();

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
