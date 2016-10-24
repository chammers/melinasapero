<?php

class jsonUserRepository extends userRepository
{
    const JSON_FILE = 'storage/users.json';

    private function getJsonFilePath()
    {
        return BASE_PATH.self::JSON_FILE;
    }

    private function getJsonHandle($mode)
    {
        if (!is_readable($this->getJsonFilePath())) {
            return false;
        }

        return fopen($this->getJsonFilePath(), $mode);
    }

    public function getById($id)
    {
        $users = $this->getAll();

        foreach ($users as $user) {
            if ($user->getId() == $id) {
                return $user;
            }
        }

        return false;
    }

    public function getAll()
    {
        //Abrir archivo con los usuarios
        $handle = $this->getJsonHandle('r');

        if (!$handle) {
            return [];
        }

        $users = [];

        //recorrer el archivo
        while($json = fgets($handle)) {
            $users[] = $this->createUserFromArray(json_decode($json, true));
        }

        fclose($handle);

        return $users;
    }

    public function update(User $user)
    {
        $users = $this->getAll();

        //Array con las líneas del archivo
        $lines = [];

        //Recorro el array de usuarios y voy generando las líneas del archivo con
        //json_encode de cada usuario, reemplazando el usuario a actualizar
        foreach ($users as $readUser) {
            $newUser = $readUser->getId() == $user->getId() ? $user : $readUser;

            $lines[] = json_encode($newUser->toArray());
        }

        //Piso el archivo con el nuevo contenido
        file_put_contents($this->getJsonFilePath(), implode("\n", $lines)."\n");
    }

    public function insert(User $user)
    {
        //Id del usuario a insertar
        $id = $this->getNextId();

        $user->setId($id);

        //Pasarlo a JSON
        $json = json_encode($user->toArray());

        //Guardarlos en el archivo
        file_put_contents($this->getJsonFilePath(), $json."\n", FILE_APPEND);

        return $id;
    }

    public function delete(User $user)
    {
        //Si el usuario no tiene id no hago nada
        if (!$user->exists()) {
            return;
        }

        $users = $this->getAll();

        //Array con las líneas del archivo
        $lines = [];

        //Recorro el array de usuarios y voy generando las líneas del archivo con
        //json_encode de cada usuario, salteando al usuario a eliminar
        foreach ($users as $readUser) {
            if ($readUser->getId() == $user->getId()) {
                continue;
            }

            $lines[] = json_encode($readUser->toArray());
        }

        //Piso el archivo con el nuevo contenido
        file_put_contents($this->getJsonFilePath(), implode("\n", $lines)."\n");
    }

    protected function getNextId()
    {
        $handle = self::getJsonHandle('r');

        //Si el archivo no es accesible, devuelvo 0
        if (!$handle) {
            return 0;
        }

        $ids = [];
        //recorrer el archivo
        while($json = fgets($handle)) {
            $userArray = json_decode($json, true);
            $ids[] = $userArray['id'];
        }

        fclose($handle);

        return max($ids) + 1;
    }

    protected function createUserFromArray(array $userArray)
    {
        $email = $userArray['email'];
        $password = $userArray['password'];
        $name = $userArray['name'];
        $lastName = $userArray['lastname'];
        $age = $userArray['age'];
        $gender = $userArray['gender'];
        $phone = $userArray['phone'];
        $id = $userArray['id'];

        return new User($email, $password, $name, $lastName, $age, $gender, $phone, $id);
    }
}
