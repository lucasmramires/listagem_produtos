<?php

if(isset($_GET["id"]) && !empty($_GET["id"])){ // verifica se existe id e se o mesmo não está vazio
    require_once "config.php";
    $sql = "DELETE FROM produto WHERE id_produto = ?"; // cria variavel para deletar o id solicitado na tabela produto
    $statement = mysqli_prepare($connection, $sql); // inicio da preparacao para serem utilizados no banco de dados
    if($statement) { 
        mysqli_stmt_bind_param($statement, "i", $param_id); 
        $param_id = trim($_GET["id"]); // enviando ao banco de dados os id fornecido pelo usuário

        if(mysqli_stmt_execute($statement)){
            header("location:list.php"); // redireciona para lista
            exit();
        } else {
            echo "Erro ao deletar o produto";
        }
    }
    mysqli_stmt_close($statement); // finaliza o statement
    mysqli_close($connection); // finaliza conexão
}

?>