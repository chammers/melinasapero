<?php
session_start();

define('BASE_PATH', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);

require('functions.php');
require('User.php');
require('UserHandler.php');
require('UserFileHandler.php');

User::autoLogin();
