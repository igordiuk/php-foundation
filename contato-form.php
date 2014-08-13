<?php
//receber os dados via POST do Formulário de Contato
$nome = $_POST['inputNome'];
$email = $_POST['inputEmail'];
$assunto = $_POST['inputAssunto'];
$mensagem = $_POST['textMensagem'];
?>
<h1 xmlns="http://www.w3.org/1999/html">Dados enviados com Sucesso!</h1>
<p>Abaixo seguem os dados que você enviou:</p>
<br/>
<p>Nome: <strong><?=$nome;?></strong></p>
<p>E-mail: <strong><?=$email;?></strong></p>
<p>Assunto: <strong><?=$assunto;?></strong></p>
<p>Texto: <strong><?=$mensagem;?></strong></p>