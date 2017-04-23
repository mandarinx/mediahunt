<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Validator;

use Category;

class CategoryValidator extends Validator {

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
}