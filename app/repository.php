<?php

abstract class repository
{
    /**
     * @var UserRepository
     */
    protected $userRepo;

    /**
     * @return UserRepository
     */
    public function getUserRepo()
    {
        return $this->userRepo;
    }
}
