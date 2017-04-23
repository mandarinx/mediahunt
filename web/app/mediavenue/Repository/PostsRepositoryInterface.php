<?php

/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

use Post;

interface PostsRepositoryInterface {

    /**
     * @param      $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $id
     * @return mixed
     */
    public function getAnyById($id);

    /**
     * @param null $type
     * @param null $category
     * @return mixed
     */
    public function getTrending($type = null, $category = null);

    /**
     * @param null   $type
     * @param null   $category
     * @param string $order
     * @return mixed
     */
    public function getLatest($type = null, $category = null, $order = 'desc');

    /**
     * @param null $type
     * @param null $category
     * @return mixed
     */
    public function getFeatured($type = null, $category = null);


    /**
     * @param $news
     * @return mixed
     */
    public function incrementViews($news);

    /**
     * @param      $term
     * @param null $type
     * @param null $category
     * @return mixed
     */
    public function search($term, $type = null, $category = null);

    /**
     * @param array $input
     * @param null  $thumbnail
     * @param null  $type
     * @return mixed
     */
    public function create(array $input, $thumbnail = null, $type = null);

    /**
     * @param Post  $posts
     * @param array $input
     * @return Post
     */
    public function edit(Post $posts, array $input);

    /**
     * @param $list
     * @return mixed
     */
    public function getFeedsForUser($list);

    //@todo add filter for admin panel
    /**
     * @return mixed
     */
    public function getApprovalRequired();

    /**
     * Admin helper, gives output irr-respective of post approved or not
     *
     * @param $id
     * @return mixed
     */
    public function getByIdForAdmin($id);

    /**
     * Admin helper, to edit post irr-respective of post approved or not
     *
     * @param Post  $posts
     * @param array $input
     * @return Post
     */
    public function adminEdit(Post $posts, array $input);

    /**
     * @param Post $post
     * @return mixed
     */
    public function findNextPost(Post $post);

    /**
     * @param Post $post
     * @return mixed
     */
    public function findPreviousPost(Post $post);

    /**
     * @param Post $post
     * @return mixed
     */
    public function findRelatedPosts(Post $post);

}