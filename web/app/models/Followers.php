<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Followers extends Eloquent {

    protected $table = 'followers';

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * @return mixed
     */
    public function followingUser()
    {
        return $this->belongsTo('User', 'follow_id');
    }
}