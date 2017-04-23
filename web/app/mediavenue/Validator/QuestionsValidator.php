<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Validator;

use Post;

class QuestionsValidator extends Validator {

    protected $createRules = [
        'title'    => ['required', 'min:3', 'max:180', 'Unique:posts'],
        'summary'  => ['required', 'min:3'],
        'category' => ['required', 'integer']
    ];

    protected $adminUpdateRules = [
        'title'    => ['required', 'min:3', 'max:180'],
        'summary'  => ['required', 'min:3'],
        'category' => ['required', 'integer']
    ];

    public function __construct(Post $model)
    {
        $this->model = $model;
    }
}