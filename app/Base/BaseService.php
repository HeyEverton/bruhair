<?php

namespace App\Base;

use App\Exceptions\NotFoundException;
use Illuminate\Http\Response;

class BaseService
{
    public function __construct(private $model)
    {
        $this->model = $model;
    }

    public function index(array $options = [])
    {
        return $this->model->paginate($options['per_page'] ?? 15);
    }

    public function create(array $payload, string $shouldReturnResource = 'no_return'): int | object
    {
        $record = $this->model->create($payload);

        if ($shouldReturnResource && $shouldReturnResource == 'return_resource') {
            return $record;
        }
        return Response::HTTP_CREATED;
    }

    public function update(array $payload, string $id)
    {
        $record = $this->show($id);

        $record->update($payload);
    }

    public function show(string $id)
    {
        $record = $this->model->find($id);

        if (!$record) {
            throw new NotFoundException(
                'Este registro não foi encontrado',
                Response::HTTP_NOT_FOUND
            );
        }

        return $record;
    }

    public function destroy(string $id): bool
    {
        $record = $this->show($id);

        return $record->delete();
    }
}
