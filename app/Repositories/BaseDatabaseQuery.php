<?php

namespace App\Repositories;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class BaseDatabaseQuery
{
    /**
     * @var string|mixed
     */
    protected string $dbName;

    public function __construct()
    {
        $this->dbName = env('DB_DATABASE');
    }

    /**
     * @return Builder
     */
    public function model(): Builder
    {
        return DB::table("{$this->dbName}.{$this->table}");
    }

    /**
     * @param array $data
     * @return int
     */
    public function create(array $data): int
    {
        return $this->model()
            ->insertGetId($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update(int $id, array $data): int
    {
        return $this->model()
            ->where("{$this->table}.id", $id)
            ->update($data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        return $this->model()
            ->where("{$this->table}.id", $id)
            ->delete();
    }

    public function findById(int $id, array $select = ['*']): object|null
    {
        return $this->model()
            ->select($select)
            ->where("{$this->table}.id", $id)
            ->first();
    }
}
