<?php

class LogInValidator extends Validator
{
    protected function populateData()
    {
        return [
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'password' => filter_input(INPUT_POST, 'password'),
            'remember' => filter_input(INPUT_POST, 'remember', FILTER_VALIDATE_INT)
        ];
    }

    protected function validateData()
    {
        $errors = [];

        if (!$this->data['email']) {
            $errors['email'] = 'Enter a valid email';
        }
        if (!$this->data['password']) {
            $errors['password'] = 'Enter password';
        }

        $user = $this->repo->getUserRepo()->getByEmail($this->data['email']);

        if (!$user) {
            $errors['email'] = 'The email is not registered';
        } else {
            if (!password_verify($this->data['password'], $user->getPassword())) {
                $errors['password'] = 'Invalid password';
            }
        }

        return $errors;
    }
}
