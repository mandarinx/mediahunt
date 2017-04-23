<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Comment extends Eloquent
{
    protected $table = 'comments';

    /**
     * @return mixed
     */
    public function getCommentPaginatedAttribute()
    {
        return $this->posts()->paginate(10);
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User','user_id');
    }

    /**
     * @return mixed
     */
    public function reply()
    {
        return $this->hasMany('Reply');
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
    public function votes()
    {
        return $this->hasMany('CommentsVotes', 'comment_id');
    }
}