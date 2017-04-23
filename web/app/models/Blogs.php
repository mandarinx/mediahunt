<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Blogs extends Eloquent {

    /**
     * @var string
     */
    protected $table = 'blogs';

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
}