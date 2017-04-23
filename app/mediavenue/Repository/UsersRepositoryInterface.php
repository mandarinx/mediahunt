<?php
/**
 * @author Abhimanyu Sharma <abhimanyusharma003@gmail.com>
 */
namespace Mediavenue\Repository;

interface UsersRepositoryInterface {

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param $username
     * @return mixed
     */
    public function getByUsername($username);

    /**
     * @param $input
     * @return bool
     */
    public function updatePassword($input);

    /**
     * @param array $input
     * @return bool
     */
    public function create(array $input);

    /**
     * @param $username
     * @param $activationCode
     * @return bool
     */
    public function activate($username, $activationCode);

    /**
     * @param $id
     * @return mixed
     */
    public function notifications($id);

    /**
     * @param array $input
     * @param null  $session
     * @return mixed
     */
    public function createFacebookUser(array $input, $session = null);

    /**
     * @param array $input
     * @param null  $session
     * @return mixed
     */
    public function createGoogleUser(array $input, $session = null);
}