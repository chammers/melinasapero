<?php

abstract class UserRepository
{
    /**
     * @param string $email
     * @return boolean
     */
    public function emailExists($email)
    {
        //Buscar el usuario por email y devolver el valor pasado a booleano
        return (bool)$this->getByEmail($email);
    }

    /**
     * @param string $email
     * @return boolean|User
     */
    public function getByEmail($email)
    {
        $users = $this->getAll();

        foreach ($users as $user) {
            if ($user->getEmail() == $email) {
                return $user;
            }
        }

        return false;
    }

    /**
     * @param User $user
     * @return boolean
     */
    public function save(User $user)
    {
        if ($user->exists()) {
            return (bool)$this->update($user);
        }
        return (bool)$this->insert($user);
    }


    abstract public function getById($id);
    abstract public function getAll();
    abstract public function insert(User $user);
    abstract public function update(User $user);
    abstract public function delete(User $user);
}
