<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Validator;

use Flags;

class FlagsValidator extends Validator {

    protected $createRules = [
        'reason' => ['required', 'min:10']
    ];


    public function __construct(Flags $model)
    {
        $this->model = $model;
    }
}