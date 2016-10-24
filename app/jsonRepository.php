<?php

class jsonRepository extends repository
{
    public function __construct()
    {
        $this->userRepo = new jsonUserRepository();
    }
}
