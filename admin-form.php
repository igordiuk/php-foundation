<?php
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
    if (!$resultado) {

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

    //inicializa a sessao
    $_SESSION['acesso'] = 1;

    //abrir uma conexao com o banco de dados e setar charset para UTF-8
    $conteudoBD = Conectar();

    //carregar os itens do menu
    $sql = "select * from menu order by pagina ";
    $stmt = $conteudoBD->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

//caso os campos estejam em branco - sugere informar login e senha
} else if ($login=='' && $password=='') {

    //nega a sessao
    $_SESSION['acesso'] = 0;
    //direciona para pagina principal mostrando erro
    header('location: /admin?log=login');

//caso a senha esteja errada, mostra mensagem de erro
} else {

    //nega a sessao
    $_SESSION['acesso'] = 0;
    //direciona para pagina principal mostrando erro
    header('location: /admin?log=error');

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


