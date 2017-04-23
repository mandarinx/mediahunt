<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Repository\Eloquent;


abstract class AbstractRepository {


    protected $model;


    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function getNew(array $attributes = [])
    {
        return $this->model->newInstance($attributes);
    }
}