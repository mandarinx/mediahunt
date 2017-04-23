<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

interface FollowRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function follow($id);
}