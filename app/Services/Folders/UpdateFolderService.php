<?php

namespace App\Services\Folders;

use App\Repositories\FolderRepository;

class UpdateFolderService
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
     * @param int $id
     * @param array $payload
     * @return array
     */
    public function update(int $id, array $payload): array
    {
        $dateNow = now();
        $data = [
            'name' => $payload['name'],
            'updated_at' => $dateNow
        ];
        $this->folderRepository->update($id, $data);
        $data['id'] = $id;
        return $data;
    }
}
