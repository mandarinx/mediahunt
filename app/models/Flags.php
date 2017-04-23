<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Flags extends Eloquent {

    /**
     * @var string
     */
    protected $table = 'flags';

    /**
     * @return mixed
     */
    public function posts()
    {
        return $this->hasMany('Posts', 'post_id');
    }

    /**
     * @return mixed
     */
    public function post()
    {
        return $this->belongsTo('Post', 'post_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }

    /**
     * @return mixed
     */
    public function reportedUser()
    {
        return $this->belongsTo('User', 'reported_user');
    }
}