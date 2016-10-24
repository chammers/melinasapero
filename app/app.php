<?php
session_start();

define('BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);

require('functions.php');
require('Auth.php');
require('User.php');
require('Repository.php');
require('JSONRepository.php');
require('UserRepository.php');
require('JSONUserRepository.php');
require('Validator.php');
require('RegisterUserValidator.php');
require('LoginValidator.php');
require('UpdateProfileValidator.php');

$repo = new JSONRepository();

$userRepo = $repo->getUserRepo();

$auth = Auth::getInstance($userRepo);

$auth->autoLogIn();

