<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Validator;

use Comment;

class CommentsValidator extends Validator {

    protected $createRules = [
        'comment' => ['required', 'min:2']
    ];


    public function __construct(Comment $model)
    {
        $this->model = $model;
    }
}