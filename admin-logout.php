<?php
//inicializa sessao
session_start();

//remove referencia da sessao
$_SESSION['acesso']=0;

//chama pagina administrativa para reorganizar menus
header('location: home')
?>