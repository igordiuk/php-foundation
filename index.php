<?php
#setar arquivo de conexao com banco de dados
include_once 'conn.php';

#lista paginas do projeto em um array simples
$pages = array("home", "empresa", "produtos", "servicos", "contato", "contato-form", "error", "buscar",
               "admin", "admin-form", "admin-editar", "admin-logout");

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


function buscar_conteudo_bd($pages) {

    #encontra a rota url completa
    $rota = parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

    #extrai o nome da url removendo apenas a primeira "/"
    $url = substr($rota['path'], 1, strlen($rota['path'])-1);

    #abrir uma conexao com o banco de dados e setar charset para UTF-8
    $conteudoBD = Conectar();

    #definir a string de consulta
    $sql = "select pagina, conteudo from menu where pagina = :url";

    #prepara a string
    $stmt = $conteudoBD->prepare($sql);

    #define o valor do parametro a ser passado
    $stmt->bindValue("url", $url);

    #executa a consulta
    $stmt->execute();

    #carrega o array com o conteudo da tabela
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    #retorna o valor do conteudo
    return $res['conteudo'];

    $conteudoBD = NULL;

}

#carrega variavel com conteudo da página
$texto = buscar_conteudo_bd($pages);

#caso não encontre texto vindo do banco de dados, busca pela pagina, normalmente
if (!$texto) {

    #chama rota para carregar conteudo
    $content = buscar_rota($pages);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

    if ($texto) {

        #encontrou texto do banco de dados
        echo $texto;

    } else {

        #utiliza metodo antigo - atraves de paginas estaticas
        require_once($content);

    }
    ?>

</div> <!-- /container -->

<!-- footer -->
<?php require_once('footer.php'); ?>

</body>
</html>