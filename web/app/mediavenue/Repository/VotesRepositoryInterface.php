<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

use Post;

interface VotesRepositoryInterface {

    /**
     * @param  Post $post
     * @return mixed
     */
    public function vote(Post $post);
}
