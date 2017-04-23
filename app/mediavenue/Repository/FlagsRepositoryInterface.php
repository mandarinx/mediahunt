<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

use Post;
use User;

interface FlagsRepositoryInterface {

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param       $id
     * @param       $reason
     * @return mixed
     */
    public function report(Post $id, $reason);

    /**
     * @param $username
     * @param $reason
     * @return mixed
     */
    public function reportUser(User $username, $reason);
}