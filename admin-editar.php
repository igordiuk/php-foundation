<?php
//verifica se usuario tem acesso a pagina verificando sua sessao, caso seja inativa, retorna com erro personalizado
if (($_SESSION['acesso'] == 0) or  (!isset($_GET['p']))) {
    header('location: /admin?log=login');
}

//recebe variaveis da pagina para carregar o conteúdo no formulario
$pagina = $_GET['p'];
$acao   = isset($_GET['f']) ? $_GET['f'] : '';

//verifica se a acao esta definida e se e um update
if ($acao!='' and $acao=='update') {

    //recebe parametros POST do Formulario
    $editarConteudo = $_POST['textConteudo'];

    //execute procedimentos para salvar registro no banco de dados - atualizando informacoes
    $salvarBD = Conectar();
    $sql = "update menu set conteudo = :conteudo where pagina = :pagina";
    $stmt = $salvarBD->prepare($sql);
    $stmt->bindValue('conteudo', $editarConteudo, PDO::PARAM_STR);
    $stmt->bindValue('pagina', $pagina, PDO::PARAM_STR);
    $stmt->execute();

    $mensagem = "Conteúdo de <b><a href='/$pagina'>$pagina</a></b> foi tualizado com Sucesso!";


} else if ($acao=='') {

    //abrir uma conexao com o banco de dados e setar charset para UTF-8
    $conteudoBD = Conectar();

    //carregar os itens do menu
    $sql = "select * from menu where pagina like :pagina ";
    $stmt = $conteudoBD->prepare($sql);
    $stmt->bindValue('pagina', "%$pagina%", PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (count($resultado) > 0) {

        $editarPagina   = $resultado['pagina'];
        $editarLink     = $resultado['link'];
        $editarConteudo = $resultado['conteudo'];
        $mensagem       = '';

    } else {

        $mensagem = 'Problemas ao carregar o Formulário de Edição de Páginas - Entre em contato com o Suporte!';

    }
}

?>
<!-- seta o arquivo do ckeditor -->
<script src="js/ckeditor/ckeditor.js"></script>

<h1>Area Administrativa - Editando Páginas</h1>
<p>Edite o conteúdo da página efetuando os ajustes necessários.</p>

<?php if ($mensagem=='') { ?>

<form class="form-horizontal" action="admin-editar?f=update&p=<?=$pagina?>" method="post">

    <!-- pagina -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputPagina">Pagina:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" name="inputPagina" placeholder="Login" value="<?=$editarPagina?>" disabled>
        </div>
    </div>
    <!-- titulo -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputLink">Link:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" name="inputLink" placeholder="Login" value="<?=$editarLink?>" disabled>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-xs-3" for="inputLink">Conteúdo:</label>
        <div class="col-xs-9">
            <textarea name="textConteudo" id="textConteudo" rows="10" cols="80">
                <?=$editarConteudo?>
            </textarea>
            <script>
                // instance, using default configuration.
                CKEDITOR.replace( 'textConteudo' );
            </script>
        </div>
    </div>

    <br>
    <!-- Botões Enviar e Limpar -->
    <div class="form-group">
        <div class="col-xs-offset-3 col-xs-9">
            <input type="submit" class="btn btn-primary" value="Salvar">
            <input type="reset" class="btn btn-default" value="Cancelar">
        </div>
    </div>

    <div class="col-x-12">
        <p><?=$mensagem?></p>
    </div>

</form>

<?php

} else {

    echo "<p>$mensagem</p>";

}
?>
