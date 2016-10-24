<?php

abstract class Repository
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