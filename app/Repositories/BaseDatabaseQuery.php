<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class BaseDatabaseQuery
{
    protected string $dbName;

    public function __construct()
    {
        $this->dbName = env('DB_DATABASE');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function model(): \Illuminate\Database\Query\Builder
    {
        return DB::table("{$this->dbName}.{$this->table}");
    }

    /**
     * @param array $data
     * @return int
     */
    public function store(array $data): int
    {
        return $this->model()
            ->insertGetId($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return int
     */
    public function update($id, array $data): int
    {
        return $this->model()
            ->where("{$this->table}.id", $id)
            ->update($data);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id): int
    {
        return $this->model()
            ->where("{$this->table}.id", $id)
            ->delete();
    }


    /**
     * @param $id
     * @param array $select
     * @return \Illuminate\Database\Query\Builder|null
     */
    public function findById($id, array $select = ['*']): \Illuminate\Database\Query\Builder|null
    {
        return $this->model()
            ->select($select)
            ->where("{$this->table}.id", $id)
            ->first();
    }
}
