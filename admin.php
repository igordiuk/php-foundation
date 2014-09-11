<?php
//define valor padrao para a Sessao, caso ela nao tenha sido definida
if (!isset($_SESSION['acesso'])) {
    $_SESSION['acesso'] = 0;
}

//definindo mensagem de erro
$log = isset($_GET['log']) ? $_GET['log'] : '';
if ($log=='error') {
    $mensagem = 'Login ou Senha inválidos!';
} else if ($log=='login') {
    $mensagem = 'Necessário informar o Login e Senha para acessar o sistema!';
} else if ($log=='end') {
    $mensagem = 'Sessão encerrada! Efetue novo Login!';
} else {
    $mensagem = '';
}

//recebe variaveis do formulario enviadas via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['inputLogin'];
    $password = $_POST['inputPassword'];
} else {
    //definir padrao
    $login = '';
    $password = '';
}

function verificaLoginBD($login, $password) {

    //abrir conexao com o banco de dados
    $existeBD = Conectar();

    //verificar existencia do Login e Senha
    $sql = "select * from usuarios where login = :login ";
    $stmt = $existeBD->prepare($sql);
    $stmt->bindValue('login', $login, PDO::PARAM_STR);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    //if retornou registro, se nao retornou cria um login e senha pré-definidos
    if (!$resultado and $login!='') {

        //definir regras do password
        $options = ['cost' => 10];

        //criptografar a senha de modo seguro
        $password = password_hash($password, PASSWORD_DEFAULT, $options);

        //armazena resultado no banco de dados
        $sql = "insert into usuarios (login, password) values ('$login', '$password')";
        $stmt = $existeBD->prepare($sql);
        $stmt->execute();

        return true;

    } else {

        //atribui variaveis ao login e senha
        $loginBD = $resultado['login'];
        $passwordBD = $resultado['password'];

        //faz a verificacao do login e senha com o banco de dados
        if (($login == $loginBD and password_verify($password, $passwordBD)==1) or ($_SESSION['acesso']==1)) {
            return true;
        }

    }

}

if (verificaLoginBD($login, $password) or ($_SESSION['acesso']==1)) {
    $_SESSION['acesso']=1;
    header('location: admin-form');
}

?>


<h1>Area Administrativa</h1>
<p>Informe seu login e senha para ter acesso a area de administraçao do site.</p>

<form class="form-horizontal" action="admin" method="post">

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