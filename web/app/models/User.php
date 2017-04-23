<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\UserTrait;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait, SoftDeletingTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany('Post', 'user_id');
    }

    /**
     * @return mixed
     */
    public function votes()
    {
        return $this->hasMany('Votes', 'user_id');
    }

    /**
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany('Comment', 'user_id');
    }

    /**
     * @return mixed
     */
    public function followers()
    {
        return $this->hasMany('Followers', 'follow_id');
    }

    /**
     * @return mixed
     */
    public function following()
    {
        return $this->hasMany('Followers', 'user_id');
    }

    /**
     * @return mixed
     */
    public function reply()
    {
        return $this->hasMany('Reply', 'user_id');
    }

    /**
     * @return mixed
     */
    public function notifications()
    {
        return $this->hasMany('Notifications', 'user_id');
    }
}
