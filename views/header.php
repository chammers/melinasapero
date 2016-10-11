<header class="main-header">
    <nav class="navbar navbar-inverse navbar-fixed-top navbar-main">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Melina's Apéritif</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href=faq.php>About us</a></li>
                    <?php if (!$auth->isLoggedIn()) : ?>
                        <li><a href="registration.php">Registration</a></li>
                    <?php endif ?>
                </ul>
                <?php if (!$auth->isLoggedIn()) : ?>
                    <form class="navbar-form navbar-right" method="post" action="login.php">
                        <div class="form-group">
                            <input type="email" name="email" id="email-login" placeholder="Email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password-login" placeholder="Password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i> Login</button>
                    </form>
                <?php else : ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= $auth->getLogged()->getName() ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="update-profile.php"><i class="fa fa-user"></i> Update Profile</a></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif ?>
            </div>
        </div>
    </nav>
</header>