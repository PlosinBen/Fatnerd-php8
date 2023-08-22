<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    use InstanceTrait;

    protected function modelFillQuery(Model $model, array $columns): Model
    {
        if (array_key_exists('orderBy', $columns)) {
            $orderBy = is_array($columns['orderBy']) ? $columns['orderBy'] : explode(',', $columns['orderBy']);

            foreach ($orderBy as $orderColumn) {
                $orderColumn = explode(' ', trim($orderColumn));
                $orderColumn[1] = strtolower($orderColumn[1]) === 'desc' ? 'DESC' : 'ASC';

                $model = $model->orderBy($orderColumn[0], $orderColumn[1]);
            }

            unset($columns['orderBy']);
        }

        foreach ($columns as $key => $value) {
            $model->where($key, $value);
        }

        return $model;
    }
}
