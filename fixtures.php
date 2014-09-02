<?php

//incluir arquivo de conexao
include_once 'conn.php';

//abrir uma conexao com o banco de dados e setar charset para UTF-8
$fixBD = Conectar();


$arquivo = fopen('scripts/fixtures.sql', 'r');

while(!feof($arquivo))
{
    //carrega instrucao SQL de cada linha do arquivo
    $sql = fgets($arquivo, 4096);
    $stmt = $fixBD->prepare($sql);
    $stmt->execute();

}

//fechar o banco de dados
$fixBD = NULL;

?>
<h1>Fixture</h1>

<p>Estrutura de testes (Fixtures) criada com sucesso!</p>