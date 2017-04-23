<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Post extends Eloquent {

    use SoftDeletingTrait;

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @return mixed
     */
    public static function scopeApproved()
    {
        return static::whereNotNull('approved_at');
    }

    /**
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo('Category', 'category_id');
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
    public function comments()
    {
        return $this->hasMany('Comment', 'post_id');
    }

    /**
     * @return mixed
     */
    public function votes()
    {
        return $this->hasMany('Votes', 'post_id');
    }

    /**
     * @return mixed
     */
    public function flags()
    {
        return $this->hasMany('Flags', 'post_id');
    }

    /**
     * @return mixed
     */
    public function reply()
    {
        return $this->hasMany('Reply', 'post_id');
    }
}