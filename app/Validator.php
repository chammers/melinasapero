<?php

abstract class Validator
{
    /**
     * @var Repository
     */
    protected $repo;
    /**
     * @var array;
     */
    protected $data;
    /**
     * @var array
     */
    protected $errors;

    public function __construct(Repository $repo)
    {
        $this->repo = $repo;
        $this->data = $this->populateData();
        $this->errors = $this->validateData();
    }

    public function getData($key = null)
    {
        return is_null($key) ? $this->data : $this->data[$key];
    }

    public function getErrors()
    {
        return $this->errors;
    }
    
    public function passes()
    {
        return empty($this->errors);
    }

    public function fails()
    {
        return !$this->passes();
    }

    abstract protected function populateData();
    abstract protected function validateData();
}
