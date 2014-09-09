<?php
//inicializa sessao em primeira instancia
session_start();

//abrir uma conexao com o banco de dados e setar charset para UTF-8
$menuBD = Conectar();

//carregar os itens do menu
$sql = "select * from menu order by id";
$stmt = $menuBD->prepare($sql);
$stmt->execute();
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand">Projeto #1</a>
            <div class="nav-collapse collapse">
                <ul class="nav nabbar-nav">
                    <?php
                    foreach($menu as $link) {
                        if($link['principal']=='S') {
                            echo "<li class='active'><a href='" . $link['pagina'] . "'>" . $link['link'] . "</a></li>";
                        } else {
                            echo "<li><a href='" . $link['pagina'] . "'>" . $link['link'] . "</a></li>";
                        }
                    }
                    //fechar conexao com o banco de dados
                    $menuBD = NULL;

                    //verifica sessao e trata link do Admin de forma inteligente
                    if (isset($_SESSION['acesso']) and ($_SESSION['acesso']!=1)) {
                       echo "<li><a href='admin'>Admin</a></li>";

                    } else {
                       echo "<li><a href='admin-form'>Admin</a></li>";
                       echo "<li><a href='admin-logout'>Logout</a></li>";
                    }
                    ?>
                    <!--
                    <li class="active"><a href="home">Home</a></li>
                    <li><a href="empresa">Empresa</a></li>
                    <li><a href="produtos">Produtos</a></li>
                    <li><a href="servicos">Serviços</a></li>
                    <li><a href="contato">Contato</a></li>
                    -->
                </ul>
                <ul class="navbar-text">
                    <form class="form-search" action="buscar" method="get">
                        <input type="text" name="q" id="q" class="input-medium search-query" placeholder="Buscar...">
                    </form>
                </ul>

            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>


