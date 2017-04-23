<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository\Eloquent;

use Blogs;
use Mediavenue\Repository\BlogsRepositoryInterface;

class BlogsRepository implements BlogsRepositoryInterface {

    /**
     * @param Blogs $blogs
     */
    public function __construct(Blogs $blogs)
    {
        $this->blogs = $blogs;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->blogs->where('id', '=', $id)->with('user')->first();
    }

    /**
     * @param null $paginate
     * @return mixed
     */
    public function getLatestBlogs($paginate = null)
    {
        $blogs = $this->blogs->orderBy('created_at', 'desc')->with('user');
        if ( ! $paginate) return $blogs->paginate(perPage());
        if ($paginate) return $blogs->paginate($paginate);

    }
}