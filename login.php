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
        $senhaArmazenada = $usuario['senha'];

        if (hash('sha256', $senha) === $senhaArmazenada) {
            session_start();
            $_SESSION['user_id'] = $usuario['id']; // Armazena o ID do usuário na sessão

            echo "<script>alert('Login bem-sucedido!');</script>";
            echo "<script>window.location.href = 'aplicacao.html';</script>";
        } else {
            echo "<script>alert('Senha incorreta. Tente novamente.');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado. Verifique seu email.');</script>";
    }

    $databaseObj->close();
}
?>
