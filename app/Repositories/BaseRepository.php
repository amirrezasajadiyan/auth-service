<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    public function __construct(protected Model $model)
    {
    }

    public function list(array $columns = ['*'], array $relations = [])
    {
        return $this->model->query()->select($columns)->with($relations)->get();
    }

    public function listPaginated(array $columns = ['*'], array $relations = [], int $perPage = 50)
    {
        return $this->model->query()->select($columns)->with($relations)->paginate($perPage);
    }

    public function findById(int $modelId, array $columns = ['*'], array $relations = [])
    {
        return $this->model->query()->select($columns)->with($relations)->findOrFail($modelId);
    }


    public function create(array $payload)
    {
        return $this->model->query()->create($payload);
    }

    public function update(int $modelId, array $payload)
    {
        $model = $this->model->query()->findOrFail($modelId);

        return $model->update($payload);
    }
}
