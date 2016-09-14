<?php
//Título de la página que se usa en head.php
$pageTitle = 'Melina\'s Apéritif';
?>
<!DOCTYPE html>
<html>
    <?php require('views/head.php') ?>
    <body>
        <?php require('views/header.php') ?>
        <section class="banner">
            <img src="images/macarons.jpg" class='macarons' alt="marcarons">
            <h1>Melina's Apéritif</h1>
            <!-- <p>Welcome to Melina's vision, where the passion for the French language meets the love for French Cuisine.*/ </p>-->
        </section>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <section class="product">
                        <img src="images/torre_eifel_lapiz.jpg" class="img_product" alt="torre_eifel_lapiz" />
                        <h2 id='h2Academic'>Academic</h2>
                        <ul class='ulAcademic'>
                            <li><a href="#">Consulting</a></li>
                            <li><a href="#">Courses</a></li>
                            <li><a href="#">Traslation</a></li>
                            <li><a href="#">Foro</a></li>
                        </ul>
                    </section>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <section class="product">
                        <img src="images/quesos_vino2.jpg" class="img_product" alt="quesos_vino2" />
                        <h2 id='h2Culinary'>Culinary</h2>
                        <ul class='ulCulinary'>
                            <li><a href="#">Restaurant</a></li>
                            <li><a href="#">Catering</a></li>
                            <li><a href="#">Consulting</a></li>
                        </ul>
                    </section>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <section class="product" id='productMargin'>
                        <img src="images/aperitif.jpg" class="img_product" alt="aperitif" />
                        <h2 id='h2Aperitif'>Apéritif</h2>
                        <ul class='ulAperitif'>
                            <li><a href="#">Apéritif</a></li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
        <?php require('views/footer.php') ?>
    </body>
</html>