<?php
require_once('app/app.php');

$user = User::getLogged();

if (!$user) {
    redirect('index.php');
}

$user->logOut();

redirect('index.php');