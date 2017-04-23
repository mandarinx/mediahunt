<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Validator;

use Post;

class PostsValidator extends Validator {

    protected $createRules = [
        'title'    => ['required', 'min:3', 'max:180'],
        'url'      => ['required', 'url'],
        'category' => ['required', 'integer']
    ];

    protected $editRules = [
        'title'    => ['required', 'min:3', 'max:180'],
        'category' => ['required', 'integer']
    ];

    protected $imageUploadRules = [
        'image'    => ['required', 'image'],
        'title'    => ['required', 'min:3', 'max:180'],
        'category' => ['required', 'integer']
    ];

    protected $linksCreateRules = [
        'title'    => ['required', 'min:3', 'max:180'],
        'url'      => ['required', 'url'],
        'category' => ['required', 'integer']
    ];

    protected $blogCreateRules = [
        'title'    => ['required', 'min:3', 'max:180'],
        'category' => ['required', 'integer']
    ];

    protected $adminEditRules = [
        'title'    => ['required', 'min:3', 'max:180'],
        'url'      => ['url'],
        'category' => ['required', 'integer']
    ];

    public function __construct(Post $model)
    {
        $this->model = $model;
    }
}