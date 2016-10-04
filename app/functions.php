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
    if (User::emailExists($data['email'])) {
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

    $user = User::getByEmail($data['email']);

    if (!$user) {
        $errors['email'] = 'The email is not registered';
    } else {
        if (!password_verify($data['password'], $user->getPassword())) {
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
