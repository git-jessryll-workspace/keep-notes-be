<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseDatabaseModel extends Model
{
    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->getDatabaseTable($this->table);
    }

    /**
     * @param $table
     * @return string
     */
    public function getDatabaseTable($table): string
    {
        if (app()->environment('testing')) {
            return $table;
        }
        $dbName = env('DB_DATABASE');
        return "{$dbName}.{$table}";
    }
}
