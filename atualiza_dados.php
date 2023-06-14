<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Você não está logado. <a href='index.php'>Faça o login</a>";
    exit;
}

$userID = $_SESSION['user_id'];

require_once 'conexao.php';
$databaseObj = new Database($host, $username, $password, $database);
$databaseObj->connect();


$query = "SELECT * FROM usuarios WHERE id = $userID";
$result = $databaseObj->executeQuery($query);

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
  
    $id = $usuario['id'];
    $nome = $usuario['nome'];
    $email = $usuario['email'];
    $horario_dormir = $usuario['horario_dormir'];
    $horario_acordar = $usuario['horario_acordar'];
    $estado = $usuario['estado'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $novo_horario_dormir = $_POST['horario_dormir'];
        $novo_horario_acordar = $_POST['horario_acordar'];
        $novo_nome = $_POST['nome_completo'];
        $novo_estado = $_POST['estado'];

        $updates = []; //array apenas com dados atualizados

        if (!empty($novo_horario_dormir)) {
            $updates[] = "horario_dormir = '$novo_horario_dormir'";
        }

        if (!empty($novo_horario_acordar)) {
            $updates[] = "horario_acordar = '$novo_horario_acordar'";
        }

        if (!empty($novo_nome)) {
            $updates[] = "nome = '$novo_nome'";
        }

        if (!empty($novo_estado)) {
            $updates[] = "estado = '$novo_estado'";
        }

        if (!empty($updates)) {
            $updateQuery = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE id = $userID";
            $updateResult = $databaseObj->executeQuery($updateQuery);

            if ($updateResult) {
                echo "<script>alert('Alterações salvas com sucesso!'); ; window.location.href = 'aplicacao.php';</script>";
            } else {
                echo "<script>alert('Erro ao salvar as alterações. Por favor, tente novamente mais tarde.');</script>";
            }
        }
    }
}

$databaseObj->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 200px;
            padding: 5px;
        }

        .submit-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Editar Perfil</h1>

    
        <div class="form-group">
            <label for="nome_completo">Nome Completo:</label>
            <input type="text" id="nome_completo" name="nome_completo" value="<?php echo $nome; ?>">
        </div>

        <div class="form-group">
            <label for="horario_dormir">Horário de Dormir:</label>
            <input type="time" id="horario_dormir" name="horario_dormir" value="<?php echo $horario_dormir; ?>">
        </div>

        <div class="form-group">
            <label for="horario_acordar">Horário de Acordar:</label>
            <input type="time" id="horario_acordar" name="horario_acordar" value="<?php echo $horario_acordar; ?>">
        </div>

        <div class="form-group">
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" value="<?php echo $estado; ?>">
        </div>

        <div class="form-group">
            <input type="submit" value="Salvar Alterações" class="submit-btn">
        </div>
    </form>
</body>
</html>
