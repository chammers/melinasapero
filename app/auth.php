<?php

class Auth
{
    private static $instance;

    /**
     * @var UserRepository
     */
    private $userRepo;

    private function __construct(userRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @return Auth
     */
    public static function getInstance(userRepository $userRepo)
    {
        if (!isset(self::$instance)) {
            self::$instance = new auth($userRepo);
        }
        return self::$instance;
    }

    public function logIn(user $user, $remember = false)
    {
        if ($remember) {
            $this->setCookie();
        }
        $_SESSION['user_id'] = $user->getId();
    }

    public function logOut()
    {
        session_destroy();
        $this->unsetCookie();
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * @return boolean|User
     */
    public function getLogged()
    {
        if (!self::isLoggedIn()) {
            return false;
        }
        return $this->userRepo->getById($_SESSION['user_id']);
    }

    public function autoLogIn()
    {
        //Si ya está logueado, no hago nada
        if (self::isLoggedIn()) {
            return;
        }

        //Si no tiene la cookie seteada no hago nada
        if (!isset($_COOKIE['user_id'])) {
            return;
        }

        $user = $this->userRepo->getById($_COOKIE['user_id']);

        //Si no encuentro un usuario para el id dado no hago nada
        if (!$user) {
            return;
        }

        //Si llega hasta acá quiere decir que no está logueado y tiene seteada la
        //cookie con un id de usuario válido
        $this->logIn($user);
    }

    private function setCookie(user $user)
    {
        setcookie('user_id', $user->getId(), time() + 60 * 60 * 24);
    }

    private function unsetCookie()
    {
        setcookie('user_id', '', -1);
    }
}
