<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class Reply extends Eloquent {

    protected $table = 'reply';

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
        return $this->belongsTo('Post', 'post_id');
    }

    /**
     * @return mixed
     */
    public function comment()
    {
        return $this->belongsTo('Comment', 'comment_id');
    }

    /**
     * @return mixed
     */
    public function votes()
    {
        return $this->hasMany('ReplyVotes', 'reply_id');
    }
}