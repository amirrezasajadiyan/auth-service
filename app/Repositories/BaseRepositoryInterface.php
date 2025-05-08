<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function list(array $columns = ['*'], array $relations = []);

    public function listPaginated(array $columns = ['*'], array $relations = [], int $perPage = 50);

    public function findById(int $modelId, array $columns = ['*'], array $relations = []);


    public function create(array $payload);

    public function update(int $modelId, array $payload);


}
