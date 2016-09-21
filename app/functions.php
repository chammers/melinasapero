<?php
function redirect($location) {
     header('Location:'.$location);
     exit;
}

function getRegistrationFormData() {
    $data = [
        'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
        'password' => filter_input(INPUT_POST, 'password'),
        'cpassword' => filter_input(INPUT_POST, 'cpassword'),
        'name' => filter_input(INPUT_POST, 'name'),
        'lastname' => filter_input(INPUT_POST, 'lastname'),
        'age' => filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT),
        'gender' => filter_input(INPUT_POST, 'gender'),
        'phone' => filter_input(INPUT_POST, 'phone')
    ];

    return $data;
}

function getLoginFormData() {
    $data = [
        'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
        'password' => filter_input(INPUT_POST, 'password'),
        'remember' => filter_input(INPUT_POST, 'remember', FILTER_VALIDATE_INT)
    ];

    return $data;
}

function getUpdateProfileFormData() {
    $data = [
        'name' => filter_input(INPUT_POST, 'name'),
        'lastname' => filter_input(INPUT_POST, 'lastname'),
        'age' => filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT),
        'gender' => filter_input(INPUT_POST, 'gender'),
        'phone' => filter_input(INPUT_POST, 'phone')
    ];

    return $data;
}

function validateRegistration() {
    $errors = [];

    $validGenders = ['male', 'female'];

    //Obtener los datos del formulario
    $data = getRegistrationFormData();

    if (!$data['email']) {
        $errors['email'] = 'Enter a valid email';
    }
    if (emailExists($data['email'])) {
        $errors['email'] = 'The email is already registered';
    }
    if (!$data['password']) {
        $errors['password'] = 'Enter password';
    }
    if (!$data['cpassword']) {
        $errors['cpassword'] = 'Confirm password';
    }
    if ($data['password'] !== $data['cpassword']) {
        $errors['password'] = 'Password don\'t match';
    }
    if (!$data['name']) {
        $errors['name'] = 'Enter name';
    }
    if (!$data['lastname']) {
        $errors['lastname'] = 'Enter last name';
    }
    if (!$data['age']) {
        $errors['age'] = 'Enter age';
    }
    if (!$data['gender'] || !in_array($data['gender'], $validGenders)) {
        $errors['gender'] = 'Enter gender';
    }

    return $errors;
}

function validateLogin(&$user) {
    $errors = [];

    $data = getLoginFormData();

    if (!$data['email']) {
        $errors['email'] = 'Enter a valid email';
    }
    if (!$data['password']) {
        $errors['password'] = 'Enter password';
    }

    $user = getUserByEmail($data['email']);

    if (!$user) {
        $errors['email'] = 'The email is not registered';
    } else {
        if (!password_verify($data['password'], $user['password'])) {
            $errors['password'] = 'Invalid password';
        }
    }

    return $errors;
}

function validateUpdateProfile() {
    $errors = [];

    $validGenders = ['male', 'female'];

    $data = getUpdateProfileFormData();

    if (!$data['name']) {
        $errors['name'] = 'Enter name';
    }
    if (!$data['lastname']) {
        $errors['lastname'] = 'Enter last name';
    }
    if (!$data['age']) {
        $errors['age'] = 'Enter age';
    }
    if (!$data['gender'] || !in_array($data['gender'], $validGenders)) {
        $errors['gender'] = 'Enter gender';
    }

    return $errors;
}

function getNextUserId() {
    $id = 0;

    //Si el archivo no es accesible, devuelvo 0
    if (!is_readable('storage/users.json')) {
        return 0;
    }

    //Abrir archivo con los usuarios
    $handle = fopen('storage/users.json', 'r');

    $ids = [];
    //recorrer el archivo
    while($json = fgets($handle)) {
        $user = json_decode($json, true);
        $ids[] = $user['id'];
    }

    fclose($handle);

    return max($ids) + 1;
}

function registerUser() {
    //Obtener los datos del formulario
    $data = getRegistrationFormData();
    
    //Armar el array del usuario. Le agrego un id único
    $user = [
        'email' => $data['email'],
        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        'name' => $data['name'],
        'lastname' => $data['lastname'],
        'age' => $data['age'],
        'gender' => $data['gender'],
        'phone' => $data['phone']
    ];

    saveUser($user);

    return $user;
}

function updateUserProfile() {
    $loggedUser = getLoggedUser();

    if (!$loggedUser) {
        return false;
    }

    //Obtener los datos del formulario
    $data = getUpdateProfileFormData();

    //Armar el array del usuario. Los campos id, email y password (hasheado) los
    //obtengo del usuario logueado
    $user = [
        'id' => $loggedUser['id'],
        'email' => $loggedUser['email'],
        'password' => $loggedUser['password'],
        'name' => $data['name'],
        'lastname' => $data['lastname'],
        'age' => $data['age'],
        'gender' => $data['gender'],
        'phone' => $data['phone']
    ];

    saveUser($user);

    return $user;
}

/**
 * Se encarga de guardar el usuario (ya sea editarlo o insertarlo). Pasa como
 * referencia para que quede guardado en el array el id que se le asigna cuando
 * es un usuario nuevo
 * @param array $user
 * @return array
 */
function saveUser(&$user) {
    //Si el usuario tiene id asignado, no es nuevo. Actualizo sus datos
    if ($user['id']) {
        return updateUser($user);
    }
    //El usuario es nuevo, lo inserto
    return insertUser($user);
}

function insertUser(&$user) {
    //Le asigno un id
    $user['id'] = getNextUserId();

    //Pasarlo a JSON
    $json = json_encode($user);

    //Guardarlos en el archivo
    file_put_contents('storage/users.json', $json."\n", FILE_APPEND);
}

function updateUser(&$user) {
    $users = getAllUsers();

    //Array con las líneas del archivo
    $lines = [];

    //Recorro el array de usuarios y voy generando las líneas del archivo con
    //json_encode de cada usuario, reemplazando el usuario a actualizar
    foreach ($users as $readUser) {
        $newUser = $readUser['id'] == $user['id'] ? $user : $readUser;

        $lines[] = json_encode($newUser);
    }

    //Piso el archivo con el nuevo contenido
    file_put_contents('storage/users.json', implode("\n", $lines)."\n");
}

function deleteUser(&$user) {
    //Si el usuario no tiene id no hago nada
    if (!isset($user['id'])) {
        return;
    }
    
    $users = getAllUsers();

    //Array con las líneas del archivo
    $lines = [];

    //Recorro el array de usuarios y voy generando las líneas del archivo con
    //json_encode de cada usuario, salteando al usuario a eliminar
    foreach ($users as $readUser) {
        if ($readUser['id'] == $user['id']) {
            continue;
        }

        $lines[] = json_encode($readUser);
    }

    //Piso el archivo con el nuevo contenido
    file_put_contents('storage/users.json', implode("\n", $lines)."\n");

    //Des-seteo el id del usuario
    unset($user['id']);

    //Deslogueo el usuario
    logOut();
}

function getAllUsers() {
    $users = [];

    //Si el archivo no existe devuelvo un array vacío
    if (!is_readable('storage/users.json')) {
        return [];
    }

    //Abrir archivo con los usuarios
    $handle = fopen('storage/users.json', 'r');

    //recorrer el archivo
    while($json = fgets($handle)) {
        $users[] = json_decode($json, true);
    }

    fclose($handle);

    return $users;
}

function getUserByEmail($email) {
    $users = getAllUsers();

    foreach ($users as $user) {
        if ($user['email'] == $email) {
            return $user;
        }
    }

    return false;
}

function getUserById($id) {
    $users = getAllUsers();

    foreach ($users as $user) {
        if ($user['id'] == $id) {
            return $user;
        }
    }

    return false;
}

function emailExists($email) {
    //Buscar el usuario por email y devolver el valor pasado a booleano
    return (bool)getUserByEmail($email);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logUser($user) {
    $data = getLoginFormData();

    if ($data['remember']) {
        saveUserCookie($user);
    }

    $_SESSION['user_id'] = $user['id'];
}

function saveUserCookie($user) {
     setcookie('user_id', $user['id'], time() + 60 * 60 * 24);
}

function logOut() {
     session_destroy();
     setcookie('user_id', '', -1);
}

function getLoggedUser() {
    if (!isLoggedIn()) {
        return false;
    }

    return getUserById($_SESSION['user_id']);
}

function autoLogin() {
    //Si ya está logueado, no hago nada
    if (isLoggedIn()) {
        return;
    }

    //Si no tiene la cookie seteada no hago nada
    if (!isset($_COOKIE['user_id'])) {
        return;
    }
    
    $user = getUserById($_COOKIE['user_id']);

    //Si no encuentro un usuario para el id dado no hago nada
    if (!$user) {
        return;
    }

    //Si llega hasta acá quiere decir que no está logueado y tiene seteada la
    //cookie con un id de usuario válido
    logUser($user);
}