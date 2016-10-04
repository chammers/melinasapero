<?php

interface UserHandler
{
    /**
     * @param User $user
     */
    public function save(User $user);

    /**
     * @param User $user
     */
    public function delete(User $user);

    /**
     * @param int $id
     * @return User
     */
    public function getById($id);

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail($email);

    /**
     * @return array
     */
    public function getAll();

    /**
     *
     * @param boolean
     */
    public function emailExists($email);
}
