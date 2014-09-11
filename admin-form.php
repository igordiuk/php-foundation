<?php
if ($_SESSION['acesso']==1) {
    //abrir uma conexao com o banco de dados e setar charset para UTF-8
    $conteudoBD = Conectar();

    //carregar os itens do menu
    $sql = "select * from menu order by pagina ";
    $stmt = $conteudoBD->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

//caso por algum motivo a sessao esteja errada, trata o problema
} else {

    //direciona para pagina principal mostrando erro
    header('location: /admin?log=login');

}

?>
<h1>Area Administrativa</h1>
<p>Bem Vindo à Área Administrativa do Site!<br>
Selecione uma Página caso deseje Editar seu conteúdo</p>


<table width="100%" border="1">
    <tr>
        <th>Item Menu</th>
        <th>Página</th>
        <th>Ação</th>
    </tr>

    <?php foreach($resultado as $pages) {?>

        <tr>
            <td><div style="text-align: left;"><?=$pages['link']?></div></td>
            <td><div style="text-align: center;"><?=$pages['pagina']?></div></td>
            <td><div style="text-align: center;"><a href="/admin-editar?p=<?=$pages['pagina']?>">Editar</a></div></td>
        </tr>

    <?php } ?>

</table>


