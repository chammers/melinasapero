<?php

class User
{
    private $id;
    private $email;
    private $password;
    private $name;
    private $lastName;
    private $age;
    private $gender;
    private $phone;

    public function __construct($email, $password, $name, $lastName, $age, $gender, $phone, $id = null)
    {
        $this->id       = $id;
        $this->email    = $email;
        $this->password = $password;
        $this->name     = $name;
        $this->lastName = $lastName;
        $this->age      = $age;
        $this->gender   = $gender;
        $this->phone    = $phone;
    }
    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return UserHandler
     */
    private static function getHandler()
    {
        return new UserFileHandler();
    }

    public static function register(array $data)
    {
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $name = $data['name'];
        $lastName = $data['lastname'];
        $age = $data['age'];
        $gender = $data['gender'];
        $phone = $data['phone'];
        
        $user = new User($email, $password, $name, $lastName, $age, $gender, $phone);

        $user->save();

        return $user;
    }

    public function updateProfile(array $data)
    {
        $this->setName($data['name']);
        $this->setLastName($data['lastname']);
        $this->setAge($data['age']);
        $this->setGender($data['gender']);
        $this->setPhone($data['phone']);

        return $this->save();
    }

    public function save()
    {
        return self::getHandler()->save($this);
    }

    /**
     * @param int $id
     * @return User
     */
    public static function getById($id)
    {
        return self::getHandler()->getById($id);
    }

    /**
     * @param string $email
     * @return User
     */
    public static function getByEmail($email)
    {
        return self::getHandler()->getByEmail($email);
    }

    /**
     * @param string $email
     * @return boolean
     */
    public static function emailExists($email)
    {
        return self::getHandler()->emailExists($email);
    }

    public function exists()
    {
        return isset($this->id);
    }

    public static function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     *
     * @return boolean|User
     */
    public static function getLogged()
    {
        if (!self::isLoggedIn()) {
            return false;
        }

        return self::getById($_SESSION['user_id']);
    }

    public function logOut()
    {
        session_destroy();
        setcookie('user_id', '', -1);
    }

    public function logIn($remember = false)
    {
        if ($remember) {
            $this->setCookie();
        }
        
        $_SESSION['user_id'] = $this->id;
    }

    protected function setCookie()
    {
        setcookie('user_id', $this->id, time() + 60 * 60 * 24);
    }

    public function delete()
    {
        //Elimino el usuario del storage
        self::getHandler()->delete($this);

        //Des-seteo el id del usuario
        $this->setId(null);

        //Deslogueo el usuario
        $this->logOut();
    }

    public static function autoLogin()
    {
        //Si ya está logueado, no hago nada
        if (self::isLoggedIn()) {
            return;
        }

        //Si no tiene la cookie seteada no hago nada
        if (!isset($_COOKIE['user_id'])) {
            return;
        }

        $user = self::getHandler()->getById($_COOKIE['user_id']);

        //Si no encuentro un usuario para el id dado no hago nada
        if (!$user) {
            return;
        }

        //Si llega hasta acá quiere decir que no está logueado y tiene seteada la
        //cookie con un id de usuario válido
        $user->logIn();
    }
}
