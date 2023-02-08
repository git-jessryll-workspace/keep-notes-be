<?php

namespace App\Services\Folders;

use App\Repositories\FolderRepository;

class CreateFolderService
{
    /**
     * @var FolderRepository
     */
    private FolderRepository $folderRepository;

    /**
     * @param FolderRepository $folderRepository
     */
    public function __construct(FolderRepository $folderRepository)
    {
        $this->folderRepository = $folderRepository;
    }

    /**
     * @param array $payload
     * @return array
     */
    public function create(array $payload): array
    {
        $dateNow = now();
        $data = [
            'name' => $payload['name'],
            'user_id' => auth()->id(),
            'created_at' => $dateNow,
            'updated_at' => $dateNow
        ];
        $data['id'] = $this->folderRepository->create($data);
        return $data;
    }
}
