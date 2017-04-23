<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */

namespace Mediavenue\Validator;

use User;

class UsersValidator extends Validator {

    protected $registrationRules = [
        'username'              => ['required', 'min:3', 'max:20', 'alpha_num', 'Unique:users'],
        'fullname'              => ['required', 'min:3', 'max:80'],
        'gender'                => ['required', 'in:male,female'],
        'email'                 => ['required', 'between:3,64', 'email', 'Unique:users'],
        'password'              => ['required', 'between:4,25', 'confirmed'],
        'password_confirmation' => ['required', 'between:4,25'],
        'g-recaptcha-response'  => ['required', 'captcha']
    ];

    protected $facebookRegistrationRules = [
        'username'              => ['required', 'min:3', 'max:20', 'alpha_num', 'Unique:users'],
        'password'              => ['required', 'between:4,25', 'confirmed'],
        'password_confirmation' => ['required', 'between:4,25'],
    ];

    protected $googleRegistrationRules = [
        'username'              => ['required', 'min:3', 'max:20', 'alpha_num', 'Unique:users'],
        'password'              => ['required', 'between:4,25', 'confirmed'],
        'password_confirmation' => ['required', 'between:4,25'],
    ];

    protected $updateRules = [
        'fullname' => ['required'],
        'gender'   => ['required', 'in:male,female'],
//        'dob'      => array('date_format:Y-m-d'),
        'blogurl'  => ['url'],
        'fb_link'  => ['url'],
        'tw_link'  => ['url']
    ];

    protected $emailUpdateRules = [
        'emailcomment'  => ['boolean'],
        'emailreply'    => ['boolean'],
        'emailfavorite' => ['boolean'],
        'emailfollow'   => ['boolean']
    ];

    protected $passwordRestRules = [
        'email'                => ['required', 'email'],
        'g-recaptcha-response' => ['required', 'captcha'],
    ];

    protected $passwordUpdateRules = [
        'password'              => ['required', 'min:6', 'confirmed'],
        'currentpassword'       => ['required'],
        'password_confirmation' => ['required', 'between:4,25']
    ];

    protected $avatarUpdateRules = [
        'avatar' => 'required|image'
    ];

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}