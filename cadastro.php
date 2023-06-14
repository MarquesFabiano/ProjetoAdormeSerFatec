<?php
require_once 'conexao.php';

$nome = $_POST['nome_completo'];
$senha = $_POST['senha'];
$email = $_POST['email'];
$idade = $_POST['idade'];
$horario_dormir = $_POST['horario_dormir'];
$horario_acordar = $_POST['horario_acordar'];
$pais = $_POST['pais'];
$estado = $_POST['estado'];

$query = "INSERT INTO usuarios (nome, senha, email, idade, horario_dormir, horario_acordar, pais, estado) VALUES ('$nome', SHA2('$senha', 256), '$email', '$idade', '$horario_dormir', '$horario_acordar', '$pais', '$estado')";

$result = $databaseObj->executeQuery($query);

if ($result) {
    echo "<script>alert('Cadastro realizado com sucesso!');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar. Por favor, tente novamente mais tarde.');</script>";
}

$databaseObj->close();
?>
