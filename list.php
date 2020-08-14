<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="stylesheet.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/9f3674b9a6.js"></script>
</head>
    <body>
    <div class = "container"> 
        <div class = "row">
            <div class = "col-sm-12">
                <h2 class = "pull-left">Lista de Produtos</h2>
                <a class = "btn btn-primary pull-right" href='insert.php'><i class="fa fa-plus-square" aria-hidden="true"></i>  Adicionar Produto</a>
            </div>
        </div>
        <?php
            require_once "config.php";
            $sql = "SELECT * FROM produto"; // criando comando para selecionar um produto
            $results = mysqli_query($connection, $sql); // executando o comando acima no BD e salvando resultados
            
            if(mysqli_num_rows($results) > 0) {  // verificar se houve resultados na busca de produtos
        ?>
            <div class = "row">
                <div class = "col-sm-12">
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Quantidade</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_array($results)) { ?> <!-- enquanto houver resultados, os mesmos serão introduzidos na tabela -->
                                <tr>
                                    <td> <?php echo $row['id_produto']; ?> </td>
                                    <td> <?php echo $row['nome_produto']; ?> </td>
                                    <td> <?php echo $row['descricao_produto']; ?> </td>
                                    <td> <?php echo $row['quantidade_produto']; ?> </td>
                                    <td>
                                        <a class = "btn btn-danger" href='delete.php?id=<?php echo $row['id_produto']; ?>'><i class="fa fa-trash-o" aria-hidden="true"></i>  Deletar</a>
                                        <a class = "btn btn-info" href='edit.php?id=<?php echo $row['id_produto']; ?>'><i class="fa fa-pencil" aria-hidden="true"></i>  Editar</a>
                                    </td>
                                </tr>
                            <?php } ?> 
                        </tbody>                         
                    </table>
                </div>
            </div>
        </div>
        <?php } else {
                echo "Não há resultados";
            }
            mysqli_close($connection); // finaliza a conexão
        ?>
        
 </body>
 </html>