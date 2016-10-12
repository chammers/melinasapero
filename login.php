<?php
require_once('app/app.php');

if ($auth->isLoggedIn()) {
    redirect('index.php');
}

$validator = new LogInValidator($repo);

if ($_POST) {
    if ($validator->passes()) {
        $auth->logIn($userRepo->getByEmail($validator->getData('email')));
        redirect('index.php');
    }

    $errors = $validator->getErrors();
}

//Obtengo los datos del formulario enviados por POST.
$data = $validator->getData();

//Título de la página que se usa en head.php
$pageTitle = 'Login - Melina\'s Apéritif';
?>
<!DOCTYPE html>
<html>
    <?php require('views/head.php') ?>
    <body>
        <?php require('views/header.php') ?>
        <div class="container">
            <h1>Login</h1>
            <div class="registration-container">
                <form class="registration" method="post">
                    <?php include('views/errors.php') ?>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $data['email'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="remember">
                            <?php if ($data['remember']) : ?>
                                <input type="checkbox" name="remember" id="remember" value="1" checked> Remember me
                            <?php else : ?>
                                <input type="checkbox" name="remember" id="remember" value="1"> Remember me
                            <?php endif ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require('views/footer.php') ?>
    </body>
</html>