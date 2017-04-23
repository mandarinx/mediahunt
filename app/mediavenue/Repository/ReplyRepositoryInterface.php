<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

interface ReplyRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param array $input
     * @return mixed
     */
    public function create(array $input);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $replyId
     * @return mixed
     */
    public function vote($replyId);

    /**
     * @param $replyId
     * @return mixed
     */
    public function deleteVote($replyId);
}