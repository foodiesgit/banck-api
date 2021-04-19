<?php

namespace App\Repo;

class BaseRepository implements BaseInterface
{
    protected $model;

    public function all()
    {
        return $this->model->all();
    }
    public function create($data)
    {
        return $this->model->create($data);
    }

    public function orderBy($field, $val)
    {
        return $this->model->orderBy($field, $val);
    }
}
