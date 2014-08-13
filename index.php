<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Code Education - PHP Foundation: Site Simples em PHP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
        }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Fav icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
</head>

<body>

<!-- menu -->
<?php require_once('menu.php'); ?>

<div class="container">

    <?php

        //recebe a página através do GET
        $content = ($_GET['menu']=='')?'home.php':$_GET['menu'];

        //se a página recebida for vazia ou arquivo invalido, exibe pagina de erro
        if(filesize($content)==0){
            $content = "error.php";
        }

        //carrega a pagina dinamicamente
        require_once($content);


    ?>

</div> <!-- /container -->

<!-- footer -->
<?php require_once('footer.php'); ?>

</body>
</html>