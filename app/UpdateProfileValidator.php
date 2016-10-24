<?php

class UpdateProfileValidator extends Validator
{
    protected function populateData()
    {
        return [
            'name' => filter_input(INPUT_POST, 'name'),
            'lastname' => filter_input(INPUT_POST, 'lastname'),
            'age' => filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT),
            'gender' => filter_input(INPUT_POST, 'gender'),
            'phone' => filter_input(INPUT_POST, 'phone')
        ];
    }

    protected function validateData()
    {
        $errors = [];

        $validGenders = ['male', 'female'];

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
