<?php
//remove referencia da sessao
$_SESSION['acesso']=0;
//joga para a pagina de administracao
header('location: admin');
?>