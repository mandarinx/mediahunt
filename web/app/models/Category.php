<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Category extends Eloquent
{

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @return mixed
     */
    public function news()
    {
        return $this->hasMany('News', 'category_id');
    }

    /**
     * @return mixed
     */
    public function questions()
    {
        return $this->hasMany('Questions', 'category_id');
    }
}