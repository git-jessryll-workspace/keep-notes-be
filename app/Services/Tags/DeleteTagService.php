<?php

namespace App\Services\Tags;

use App\Repositories\TagRepository;

class DeleteTagService
{
    /**
     * @var TagRepository
     */
    private TagRepository $tagRepository;

    /**
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param int $id
     * @return string[]
     */
    public function delete(int $id): array
    {
        $this->tagRepository->update($id, [
            'taggable_id' => null,
            'taggable_type' => null
        ]);
        return ['message' => 'Data deleted'];
    }
}
