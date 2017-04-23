<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
class ReplyVotes extends Eloquent {

    /**
     * @var string
     */
    protected $table = 'reply_votes';

    /**
     * @return mixed
     */
    public function reply()
    {
        return $this->belongsTo('Reply', 'reply_id');
    }

    /**
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
}