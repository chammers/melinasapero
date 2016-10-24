<?php
require_once('app/app.php');

//Título de la página que se usa en head.php
$pageTitle = 'Frequently Asked Questions - FAQ - Melina\'s Apéritif';

//Array de preguntas
$faqs = [
    [
        'question' => 'Who is Melina?',
        'answer' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>'
    ],
    [
        'question' => 'What is her vision?',
        'answer' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>'
    ],
    [
        'question' => 'What is her Academic offer?',
        'answer' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>'
    ],
    [
        'question' => 'What is her Culinary offer?',
        'answer' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>'
    ],
    [
        'question' => 'What is Aperetiff?',
        'answer' => '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in </p>'
    ]
];
?>
<!DOCTYPE html>
<html>
    <?php require('views/head.php') ?>
    <body>
        <?php require('views/header.php') ?>
        <div class="container">
            <h1>F.A.Q.</h1>
            <section class="faq">
                <ul class="list-unstyled">
                    <?php foreach ($faqs as $i => $faq) : ?>
                        <li>
                          <!-- js ocultar respuestas -->
                            <div class="panel panel-default" onclick ="mostrar(this)" ondblclick="ocultar(this)" data-oculto="<?= $i + 1 ?>">
                              <div class="panel-heading" >
                                  <h3 class="panel-title question"><?= $faq['question'] ?></h3>
                              </div>
                                <!-- js ocultar respuestas -->
                              <div class="panel-body answer" id='oculto-<?= $i + 1?>' style="display:none;">
                                  <?= $faq['answer'] ?>
                              </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
          </section>
        </div>
    <?php require('views/footer.php') ?>
        <script type="text/javascript">
            function mostrar(element){
                var oculto = element.getAttribute('data-oculto');
                document.getElementById('oculto-'+oculto).style.display = 'block';
            }
            function ocultar(element){
                var oculto = element.getAttribute('data-oculto');
                document.getElementById('oculto-'+oculto).style.display = 'none';
            }
          </script>
    </body>
</html>
