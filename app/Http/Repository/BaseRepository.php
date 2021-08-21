<?php

namespace App\Http\Repository;

use Illuminate\Database\Eloquent\Model;
use App\Http\Interfaces\BaseInterface;
use Illuminate\Support\Collection;

class BaseRepository implements BaseInterface
{
    protected $model;

    public function __construct(Model $model) // new User();
    {
        $this->model = $model;
    }

    public function paginate($limit = 10 , array $options = [])
    {
        foreach ($options as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, "=", $value);
            }
        }

        return $this->model->paginate($limit);
    }

    public function all(array $options = []): Collection
    {
        foreach ($options as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model = $this->model->where($field, $condition, $val);
            } else {
                $this->model = $this->model->where($field, "=", $value);
            }
        }

        return $this->model->get();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function findWhere(array $options = [], $columns = ['*']): ?Model
    {
        foreach ($options as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $this->model =  $this->model->where($field, $condition, $val);
            } else {
                $this->model =  $this->model->where($field, "=", $value);
            }
        }

        return $this->model->get($columns)->first();
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }
}
