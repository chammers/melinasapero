<?php
require_once('app/app.php');

if ($auth->isLoggedIn()) {
    redirect('index.php');
}

$validator = new RegisterUserValidator($repo);

//Obtengo los datos del formulario enviados por POST.
$data = $validator->getData();

if ($_POST) {
    if ($validator->passes()) {
        User::register($userRepo, $data);
        
        redirect('index.php');
    }

    $errors = $validator->getErrors();
}



//Título de la página que se usa en head.php
$pageTitle = 'Registration - Melina\'s Apéritif';
?>
<!DOCTYPE html>
<html>
    <?php require('views/head.php') ?>
    <body>
        <?php require('views/header.php') ?>
        <div class="container">
            <h1>Registration</h1>
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
                        <label for="cpassword">Confirm password</label>
                        <input type="password" name="cpassword" id="cpassword" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $data['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $data['lastname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control" min="0" value="<?= $data['age'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Gender</label><br>
                        <label for="male">
                            <?php if ($data['gender'] == 'male') : ?>
                                <input type="radio" name="gender" value="male" id="male" checked> Male
                            <?php else : ?>
                                <input type="radio" name="gender" value="male" id="male"> Male
                            <?php endif ?>
                        </label>
                        <label for="female">
                            <?php if ($data['gender'] == 'female') : ?>
                                <input type="radio" name="gender" value="female" id="female" checked> Female
                            <?php else : ?>
                                <input type="radio" name="gender" value="female" id="female"> Female
                            <?php endif ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?= $data['phone'] ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require('views/footer.php') ?>
    </body>
</html>