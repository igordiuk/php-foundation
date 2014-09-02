<?php
#tratando o termo a ser localizado nas páginas
$termo = $_GET['q'];

//abrir uma conexao com o banco de dados e setar charset para UTF-8
$conteudoBD = Conectar();

//carregar os itens do menu
$sql = "select * from menu where conteudo like :conteudo ";
$stmt = $conteudoBD->prepare($sql);
$stmt->bindValue('conteudo', "%$termo%", PDO::PARAM_STR);
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($resultado);
?>
<h1>Buscar no Site</h1>

<?php
if ($total==0) {
   echo "<p>Nenhuma informação localizada referente ao termo: <b>$termo</b></p>";
} else {
   if ($termo!='') {
      echo "<p>Encontramos <b>$total</b> página(s) contendo o termo <b>$termo</b></p>";
   } else {
      echo "<p>Encontramos <b>$total</b> página(s) acessíveis neste website. </br>Sugerimos que especifique melhor sua consulta para obter melhores resultados.</p>";
   }

?>

<table width="100%" border="1">
    <tr>
        <th>Item Menu</th>
        <th>Página</th>
    </tr>

    <?php foreach($resultado as $pages) {?>

    <tr>
        <td><div style="text-align: left;"><?=$pages['link']?></div></td>
        <td><div style="text-align: center;"><a href="/<?=$pages['pagina']?>"><?=$pages['pagina']?></a></div></td>
    </tr>

    <?php } ?>

</table>


<?php } ?>
