<?php
/*
 * Le arquivo config.ini para buscar os parametros de conexao com o banco de dados
 */
function Conectar() {

    //verifica se existe arquivo de configuracao para este banco de dados
    if(file_exists("config.ini")) {

        //le o arquivo INI e retorna um array
        $param = parse_ini_file("config.ini");

    } else {

        //se nao existir lanca um erro
        throw new Exception("Arquivo de configuração não encontrado!");

    }

    //le as informacoes contidas no arquivo
    $user = isset($param['user']) ? $param['user'] : NULL;
    $pass = isset($param['pass']) ? $param['pass'] : NULL;
    $name = isset($param['name']) ? $param['name'] : NULL;
    $host = isset($param['host']) ? $param['host'] : NULL;
    $type = isset($param['type']) ? $param['type'] : NULL;
    $port = isset($param['port']) ? $param['port'] : NULL;

    //verifica a porta, caso não tenha sido definida, seta padrao
    $port = $port ? $port : '3306';

    try {
        //realiza a conexao e seta o charset para UTF-8
        return new \PDO("{$type}:host={$host}; port={$port}; dbname={$name}", $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    catch (\PDOException $e) {
        return die("Erro ao conectar: " . $e->getCode() . " - " . $e->getMessage());
    }

}

