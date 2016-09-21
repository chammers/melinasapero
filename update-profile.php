<?php
require_once('app/app.php');

if (!isLoggedIn()) {
    redirect('index.php');
}

if ($_POST) {
    if (isset($_POST['delete']) && $_POST['delete']) {
        $user = getLoggedUser();
        deleteUser($user);
        redirect('index.php');
    }
    $errors = validateUpdateProfile();

    if (empty($errors)) {
        updateUserProfile();
    }
}

$user = getLoggedUser();

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
                        <input type="text" name="name" id="name" class="form-control" value="<?= $user['name'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control" value="<?= $user['lastname'] ?>">
                    </div>
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" name="age" id="age" class="form-control" min="0" value="<?= $user['age'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Gender</label><br>
                        <label for="male">
                            <?php if ($user['gender'] == 'male') : ?>
                                <input type="radio" name="gender" value="male" id="male" checked> Male
                            <?php else : ?>
                                <input type="radio" name="gender" value="male" id="male"> Male
                            <?php endif ?>
                        </label>
                        <label for="female">
                            <?php if ($user['gender'] == 'female') : ?>
                                <input type="radio" name="gender" value="female" id="female" checked> Female
                            <?php else : ?>
                                <input type="radio" name="gender" value="female" id="female"> Female
                            <?php endif ?>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="<?= $user['phone'] ?>">
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
