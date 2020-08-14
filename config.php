<?php 

// definindo variáveis para conexão com banco de dados
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'lista_produtos');

// tentativa de conexão com banco de dados
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//mensagem para falha na conexão
if($connection === false){

    die("Não foi possível realizar a conexão. Motivo:" . mysqli_connect_error());

}

?>