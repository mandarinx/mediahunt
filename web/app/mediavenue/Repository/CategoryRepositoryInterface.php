<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

interface CategoryRepositoryInterface {

    /**
     * @param $name
     * @return mixed
     */
    public function getByName($name);

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug);
}