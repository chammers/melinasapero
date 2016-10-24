<?php

class registerUserValidator extends validator
{
    public function populateData()
    {
        return [
            'email' => filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL),
            'password' => filter_input(INPUT_POST, 'password'),
            'cpassword' => filter_input(INPUT_POST, 'cpassword'),
            'name' => filter_input(INPUT_POST, 'name'),
            'lastname' => filter_input(INPUT_POST, 'lastname'),
            'age' => filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT),
            'gender' => filter_input(INPUT_POST, 'gender'),
            'phone' => filter_input(INPUT_POST, 'phone')
        ];
    }

    protected function validateData()
    {
        $userRepo = $this->repo->getUserRepo();

        $errors = [];

        $validGenders = ['male', 'female'];

        if (!$this->data['email']) {
            $errors['email'] = 'Enter a valid email';
        }
        if ($userRepo->emailExists($this->data['email'])) {
            $errors['email'] = 'The email is already registered';
        }
        if (!$this->data['password']) {
            $errors['password'] = 'Enter password';
        }
        if (!$this->data['cpassword']) {
            $errors['cpassword'] = 'Confirm password';
        }
        if ($this->data['password'] !== $this->data['cpassword']) {
            $errors['password'] = 'Password don\'t match';
        }
        if (!$this->data['name']) {
            $errors['name'] = 'Enter name';
        }
        if (!$this->data['lastname']) {
            $errors['lastname'] = 'Enter last name';
        }
        if (!$this->data['age']) {
            $errors['age'] = 'Enter age';
        }
        if (!$this->data['gender'] || !in_array($this->data['gender'], $validGenders)) {
            $errors['gender'] = 'Enter gender';
        }

        return $errors;
    }
}
