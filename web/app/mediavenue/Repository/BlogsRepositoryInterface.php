<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

interface BlogsRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param null $paginate
     * @return mixed
     */
    public function getLatestBlogs($paginate = null);

}