<?php
//definindo mensagem
$login = isset($_GET['log']) ? $_GET['log'] : '';
if ($login=='error') {
    $mensagem = 'Login ou Senha inválidos!';
} else if ($login=='login') {
    $mensagem = 'Necessário informar o Login e Senha para acessar o sistema!';
} else if ($login=='end') {
    $mensagem = 'Sessão encerrada! Efetue novo Login!';
} else {
    $mensagem = '';
}

?>


<h1>Area Administrativa</h1>
<p>Informe seu login e senha para ter acesso a area de administraçao do site.</p>

<form class="form-horizontal" action="admin-form" method="post">

    <!-- login -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputLogin">Login:</label>
        <div class="col-xs-9">
            <input type="text" class="form-control" id="inputLogin" name="inputLogin" placeholder="Login" value="admin">
        </div>
    </div>
    <!-- senha -->
    <div class="form-group">
        <label class="control-label col-xs-3" for="inputPassword">Senha:</label>
        <div class="col-xs-9">
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Senha" value="123456">
        </div>
    </div>

    <!-- mensagem -->
    <?php if ($mensagem) { ?>
    <br>
    <div class="form-group">
        <div class="col-xs-12">
            <p><b><?php echo $mensagem; ?></b></p>
        </div>
    </div>
    <?php } ?>
    <br>
    <!-- Botões Enviar e Limpar -->
    <div class="form-group">
        <div class="col-xs-offset-3 col-xs-9">
            <input type="submit" class="btn btn-primary" value="Enviar">
            <input type="reset" class="btn btn-default" value="Limpar">
        </div>
    </div>

</form>