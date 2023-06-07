<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Você não está logado. <a href='login.php'>Faça o login</a>";
    exit;
}

$userID = $_SESSION['user_id'];

require_once 'conexao.php';
$databaseObj = new Database($host, $username, $password, $database);
$databaseObj->connect();

// puxar do db adormeser os dados
$query = "SELECT * FROM usuarios WHERE id = $userID";
$result = $databaseObj->executeQuery($query);

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
  
    $id = $usuario['id'];
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $duracaoSono = $usuario['duracao_sono'];

   //calculando a idade
    $dataNascimento = new DateTime($usuario['idade']);
    $dataAtual = new DateTime();
    $intervalo = $dataAtual->diff($dataNascimento);
    $idade = $intervalo->y;


}
$databaseObj->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página Restrita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .user-info strong {
            width: 100px;
            display: inline-block;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #f44336;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Página Restrita</h1>

    <div class="user-info">
        <strong>ID:</strong> <?php echo $id; ?><br>
        <strong>Nome:</strong> <?php echo $nome; ?><br>
        <strong>Email:</strong> <?php echo $email; ?><br>
        <strong>Idade:</strong> <?php echo $idade; ?><br>
        <strong>Duração do sono:</strong> <?php echo $duracaoSono; ?><br>
    </div>

    <!-- Botão de logout -->
    <a href="logout.php" class="logout-btn">Logout</a>

    <script>
        var duracaoSono = "<?php echo $duracaoSono; ?>";
        var idade = <?php echo $idade; ?>;

        var mensagem = "Você tem " + idade + " anos e está dormindo por " + duracaoSono + " horas.";

        if (idade <= 3 && duracaoSono >= 12) {
            mensagem += " Isso é uma quantidade adequada de sono para a sua idade.";
        } else if (idade >= 4 && idade <= 13 && duracaoSono >= 10 && duracaoSono <= 12) {
            mensagem += " Isso é uma quantidade adequada de sono para a sua idade.";
        } else if (idade >= 14 && idade <= 17 && duracaoSono >= 8 && duracaoSono <= 10) {
            mensagem += " Isso é uma quantidade adequada de sono para a sua idade.";
        } else if (idade >= 18 && duracaoSono >= 7 && duracaoSono <= 9) {
            mensagem += " Isso é uma quantidade adequada de sono para a sua idade.";
        } else {
            mensagem += " A quantidade de sono pode não ser adequada para a sua idade. Considere ajustar seus horários de sono.";
        }

        var mensagemElement = document.createElement("p");
        mensagemElement.textContent = mensagem;
        document.body.appendChild(mensagemElement);
    </script>
</body>
</html>
