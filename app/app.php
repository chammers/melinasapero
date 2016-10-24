<?php
session_start();

define('BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);

require('functions.php');
require('auth.php');
require('user.php');
require('repository.php');
require('jsonRepository.php');
require('userRepository.php');
require('jsonUserRepository.php');
require('validator.php');
require('registerUserValidator.php');
require('loginValidator.php');
require('updateProfileValidator.php');

$repo = new jsonRepository();

$userRepo = $repo->getUserRepo();

$auth = auth::getInstance($userRepo);

$auth->autoLogIn();
