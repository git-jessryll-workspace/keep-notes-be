<?php

namespace App\Services\Tags;

use App\Repositories\TagRepository;
use Illuminate\Validation\ValidationException;

class CreateTagService
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
     * @param array $payload
     * @return array
     * @throws ValidationException
     */
    public function create(array $payload): array
    {
        $dateNow = now();
        request()['taggable_type'] = $payload['type'];
        request()['taggable_id'] = $payload['tag_id'];
        if (!in_array($payload['type'], ['FOLDER', 'NOTE'])) {
            throw ValidationException::withMessages([
                'error_message' => "Something went wrong!"
            ])->status(401);
        }
        $tag = $this->tagRepository->findFirst();
        if ($tag) {
            return collect($tag)->toArray();
        }
        $tagData = [
            'label' => $payload['label'],
            'taggable_id' => $payload['tag_id'],
            'taggable_type' => $payload['type'],
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
        ];

        $tagData['id'] = $this->tagRepository->create($tagData);
        return $tagData;
    }
}
