<?php
    require_once "config.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){ // verificando se existe envio de informações por via de formulario
        $temp_name = trim($_POST["name"]);
        $temp_description = trim($_POST["description"]);
        $temp_quantity = trim($_POST["quantity"]);
        $name = $description = $quantity = "";

        if(empty($temp_name)){
            $error_name = "É necessário inserir um nome.";
        } else {
            $sql = "SELECT * FROM produto WHERE nome_produto = ?"; // seleciona os dados da coluna nome_produto, do banco de dados
            $statement = mysqli_prepare($connection, $sql); // iniciando preparação de dados

            if($statement) { 
                mysqli_stmt_bind_param($statement, "s", $param_name);
                $param_name = $temp_name;

                if(mysqli_stmt_execute($statement)){ // verifica a execução do statement
                   
                    $result = mysqli_stmt_get_result($statement);

                    if(mysqli_num_rows($result) > 0) {
                        $error_name = "Este produto já existe.";
                    } else {
                        $name = $temp_name;
                    }
                } 
            }
            mysqli_stmt_close($statement);
        }

        if(empty($temp_description)){ 
            $error_description = "É necessário inserir uma descrição.";
        } else {
            $description = $temp_description;
        }

        if(empty($temp_quantity)){
            $error_quantity = "É necessário inserir uma descrição.";
        } else {
            $quantity = $temp_quantity;
        }

        if(empty($error_quantity) && empty($error_name) && empty($error_description)){
            $sql = "UPDATE produto SET nome_produto = ?, descricao_produto = ?, quantidade_produto = ? WHERE id_produto = ?"; // atualiza informações do produto, baseado no id do mesmo
            $statement = mysqli_prepare($connection, $sql); // inicia preparação de informações

            if($statement) { 
                mysqli_stmt_bind_param($statement, "ssii",  $param_name, $param_description, $param_quantity, $param_id); // introdução de parâmetros
                $param_name = $name;
                $param_description = $description;
                $param_quantity = $quantity;
                $param_id = trim($_GET["id"]);

                if(mysqli_stmt_execute($statement)){ // execução do statement
                    header("location:index.php");
                    exit();
                } else {
                    echo "O produto não pôde ser adicionado.";
                }
            }
            mysqli_stmt_close($statement); // finalização do statement
        } else {
            echo "Algum campo não está preenchido corretamente.";
        }
        mysqli_close($connection);// finalização da conexão
    } else {
        if(isset($_GET["id"]) && !empty($_GET["id"])) {
            $sql = "SELECT nome_produto, descricao_produto, quantidade_produto FROM produto WHERE id_produto = ? "; // seleciona as informações do produto, da tabela produto, pelo id
            $statement = mysqli_prepare($connection, $sql); 

            if($statement) { 
                mysqli_stmt_bind_param($statement, "i", $param_id);
                $param_id = trim($_GET["id"]);

                if(mysqli_stmt_execute($statement)){
                    $result = mysqli_stmt_get_result($statement);

                    if(mysqli_num_rows($result) == 1) {
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $name = $row["nome_produto"];
                        $description = $row["descricao_produto"];
                        $quantity = $row["quantidade_produto"];
                    } else {
                        echo "Não foi possível buscar o id válido.";
                    }
                } else {
                    echo "Erro ao alterar o produto.";
                }
            }
            mysqli_stmt_close($statement);
            mysqli_close($connection);
        } else {
            echo "Não foi possível receber um id válido.";
        }
    }

?>

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
                <h2>Edição de Produtos</h2>
                <p>Esta seção é para a edição do produto selecionado<p>
                <form action = "<?php htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method = "POST">
                    <div class = form-group>
                        <label>Nome do Produto</label>
                        <input type = "text" name = "name" class = "form-control" value = "<?php echo $name; ?>" placeholder = "Nome do produto">
                    </div>
                    <div class = form-group>
                        <label>Descrição</label>
                        <input type = "text" name = "description" class = "form-control" value = "<?php echo $description; ?>" placeholder = "Descrição">
                    </div>
                    <div class = form-group>
                        <label>Quantidade</label>
                        <input type = "text" name = "quantity" class = "form-control" value = "<?php echo $quantity; ?>" placeholder = "Quant.">
                    </div>
                    <input type = "submit" class = "btn btn-success" value = "Enviar">
                    <a class = "btn btn-danger" href='index.php'>Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>