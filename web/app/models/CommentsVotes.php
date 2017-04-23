<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class CommentsVotes extends Eloquent {

    protected $table = 'comments_votes';

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
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}