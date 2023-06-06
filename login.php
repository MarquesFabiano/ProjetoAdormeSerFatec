<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $databaseObj = new Database($host, $username, $password, $database);
    $databaseObj->connect();

    $query = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $databaseObj->executeQuery($query);

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {

            echo 'Login bem-sucedido!';
        } else {
            echo 'Senha incorreta. Tente novamente.';
        }
    } else {
        echo 'Usuário não encontrado. Verifique seu email.';
    }

    $databaseObj->close();
}
?>
