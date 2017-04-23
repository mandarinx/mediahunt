<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Category;
use Mediavenue\Repository\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface {

    /**
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @param $name
     * @return bool
     */
    public function getByName($name)
    {
        $category = $this->category->whereName($name)->first();
        if ($category)
            return $category;

        return false;
    }

    /**
     * @param $slug
     * @return bool
     */
    public function getBySlug($slug)
    {
        $category = $this->category->whereSlug($slug)->first();
        if ($category)
            return $category;

        return false;
    }


}