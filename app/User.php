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

    public static function register(UserRepository $userRepo, array $data)
    {
        $email = $data['email'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $name = $data['name'];
        $lastName = $data['lastname'];
        $age = $data['age'];
        $gender = $data['gender'];
        $phone = $data['phone'];
        
        $user = new User($email, $password, $name, $lastName, $age, $gender, $phone);

        $userRepo->save($user);

        return $user;
    }

    public function updateProfile(UserRepository $userRepo, array $data)
    {
        $this->setName($data['name']);
        $this->setLastName($data['lastname']);
        $this->setAge($data['age']);
        $this->setGender($data['gender']);
        $this->setPhone($data['phone']);

        return $userRepo->save($this);
    }

    public function exists()
    {
        return isset($this->id);
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'name' => $this->getName(),
            'lastname' => $this->getLastName(),
            'age' => $this->getAge(),
            'gender' => $this->getGender(),
            'phone' => $this->getPhone()
        ];
    }
}
