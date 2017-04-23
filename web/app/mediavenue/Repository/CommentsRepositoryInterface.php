<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

interface CommentsRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $postId
     * @param $input
     * @return mixed
     */
    public function create($postId, array $input);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $id
     * @return mixed
     */
    public function vote($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deleteVote($id);
}