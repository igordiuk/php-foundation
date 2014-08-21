<?php
#lista paginas do projeto em um array simples
$pages = array("home", "empresa", "produtos", "servicos", "contato", "contato-form", "error");

#define funcao para encontrar a rota
function buscar_rota($pages) {

    #encontra a rota url completa
    $rota = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

    #extrai o nome da url removendo apenas a primeira "/"
    $url = substr($rota['path'], 1, strlen($rota['path'])-1);

    #verificar se url esta relacionada no array de paginas do site - $pages
    if (in_array($url, $pages)) {

        #se encontrou - carrega a pagina
        return $url.".php";

    } else if($url=='') {

        #se esta em branco - carrega a pagina inicial - home.php
        return "home.php";

    } else if (!file_exists($url."php")) {

        #se o arquivo solicitado não pode ser encontrado
        #contar quantas pastas foram acessadas ou tentativa de acesso a pastas
        $i = substr_count($url, '/');

        if ($i == 0) {

            #esta na pasta raiz, apenas exibe o erro
            return "error.php";

        } else {

            #define variavel $path para armazenar caminho raiz para redirecionamento
            $path = "";

            #executa um for para recuperar o caminho original (raiz)
            for ($j = 0; $j < $i; $j++) {
                $path .= "../";
            }

            #direciona o site para a pagina padrao de erro no diretorio raiz do site
            header("location:".$path."error");

        }

    }
}

#chama rota para carregar conteudo
$content = buscar_rota($pages);

?>
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
    <?php require_once($content); ?>
</div> <!-- /container -->

<!-- footer -->
<?php require_once('footer.php'); ?>

</body>
</html>