<?php
require_once('app/app.php');

if (!$auth->isLoggedIn()) {
    redirect('index.php');
}

$user = $auth->getLogged();

$validator = new UpdateProfileValidator($repo);

if ($_POST) {
    if (isset($_POST['delete']) && $_POST['delete']) {
        //Elimino el usuario del storage
        $userRepo->delete($user);

        //Des-seteo el id del usuario (en este script no sirve de nada. Podría
        //servir si después se hace algo con el objeto usuario que dependa de si
        //existe o no en el storage
        $user->setId(null);

        //Deslogueo el usuario
        $auth->logOut();
        
        redirect('index.php');
    }

    if ($validator->passes()) {
        $data = $validator->getData();

        $user->updateProfile($userRepo, $data);
    } else {
        $errors = $validator->getErrors();
    }
}

//Título de la página que se usa en head.php
$pageTitle = 'Update Profile - Melina\'s Apéritif';
?>
<!DOCTYPE html>
<html>
    <?php require('views/head.php') ?>
    <body>
        <?php require('views/header.php') ?>
        <div class="container">
            <h1>Update profile</h1>
            <div class="registration-container">
                <form class="registration" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $user->getName() ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $user->getLastName() ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control" min="0" value="<?= $user->getAge() ?>">
                    </div>
                    <div class="form-group">
                        <label>Gender</label><br>
                        <label for="male">
                            <?php if ($user->getGender() == 'male') : ?>
                                <input type="radio" name="gender" value="male" id="male" checked> Male
                            <?php else : ?>
                                <input type="radio" name="gender" value="male" id="male"> Male
                            <?php endif ?>
                        </label>
                        <label for="female">
                            <?php if ($user->getGender() == 'female') : ?>
                                <input type="radio" name="gender" value="female" id="female" checked> Female
                            <?php else : ?>
                                <input type="radio" name="gender" value="female" id="female"> Female
                            <?php endif ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?= $user->getPhone() ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                    <button type="submit" class="btn btn-danger" id="delete-account" name="delete" value="1"><i class="fa fa-remove"></i> Delete Account</button>
                </form>
            </div>
        </div>
        <?php require('views/footer.php') ?>
        <script>
            $(document).ready(function() {});

            $('#delete-account').click(function(e) {
                if (!confirm('Are you sure?')) {
                    e.preventDefault();
                }
            });
        </script>
    </body>
</html>
