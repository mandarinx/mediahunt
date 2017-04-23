<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Notifications extends Eloquent {

    protected $table = 'notifications';

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
    public function post()
    {
        return $this->belongsTo('Post', 'on_id');
    }

    /**
     * @return mixed
     */
    public function fromUser()
    {
        return $this->belongsTo('User', 'from_id');
    }
}