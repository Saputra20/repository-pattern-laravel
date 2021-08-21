<?php

namespace App\Http\Interfaces;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

/**
 * Interface BaseInterface
 * @package App\Http\Interfaces
 */
interface BaseInterface
{
    public function paginate($limit = 10 ,array $options = []);

    public function all(array $options = []): Collection;

    public function find($id): ?Model;

    public function findWhere(array $options = [], $columns = ['*']): ?Model;

    public function create(array $attributes): Model;
}
