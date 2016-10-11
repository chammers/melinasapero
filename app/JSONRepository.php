<?php

class JSONRepository extends Repository
{
    public function __construct()
    {
        $this->userRepo = new JSONUserRepository();
    }
}
