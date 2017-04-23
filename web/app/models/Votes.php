<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Votes extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'votes';

    /**
     * @return mixed
     */
    public function post()
    {
        return $this->belongsTo('post', 'post_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}