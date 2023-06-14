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

<!doctype html>
<html lang="pt-br" data-bs-theme="auto">
<head>
  <script src="assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PI</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="w-auto p-3 bgcor9">
<div class="container">
  <main class="d-flex flex-wrap justify-content-center">
    <div class="py-5 text-center txtcor1">
      <img class="d-block mx-auto mb-4 rounded-circle" src="imagem/logo1.png" alt="" width="92" height="77">
      <h2>Vamos atualizar seus dados!</h2>
      <p class="lead bgcor6">insira abaixo os novos dados.</p>
    </div>

    <div class="col-md-7 col-lg-8 txtcor1">

      <br>
      <form class="needs-validation" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row g-3">
          <div class="col-sm-12">
            <label for="Nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="Nome" name="nome_completo" placeholder="Nome Completo" value="<?php echo $nome; ?>" required>
            <div class="invalid-feedback">
              Por favor digite seu nome completo.
            </div>


          <div class="col-sm-4">
            <label for="Dormir" class="form-label">Horário de Dormir</label>
            <input type="time" class="form-control" id="Dormir" name="horario_dormir" placeholder="Horário de Dormir" value="<?php echo $horario_dormir; ?>" required>
            <div class="invalid-feedback">
              Por favor digite seu horário de dormir.
            </div>
          </div>


          <div class="col-sm-4">
            <label for="Acordar" class="form-label">Horário de Acordar</label>
            <input type="time" class="form-control" id="Acordar" name="horario_acordar" placeholder="Horário de Acordar" value="<?php echo $horario_acordar; ?>" required>
            <div class="invalid-feedback">
              Por favor digite seu horário de acordar.
            </div>
          </div>>

          <div class="col-sm-6">
            <label for="Estado" class="form-label" value="<?php echo $estado; ?>" >Estado</label>
            <select class="form-select" id="Estado" name="estado" required>
              <option value="">Escolha</option>
              <option>Acre</option>
              <option>Alagoas</option>
              <option>Amapá</option>
              <option>Amazonas</option>
              <option>Bahia</option>
              <option>Ceará</option>
              <option>Distrito Federal</option>
              <option>Espírito Santo</option>
              <option>Goiás</option>
              <option>Maranhão</option>
              <option>Mato Grosso</option>
              <option>Mato Grosso do Sul</option>
              <option>Minas Gerais</option>
              <option>Pará</option>
              <option>Paraíba</option>
              <option>Paraná</option>
              <option>Pernambuco</option>
              <option>Piauí</option>
              <option>Rio de Janeiro</option>
              <option>Rio Grande do Norte</option>
              <option>Rio Grande do Sul</option>
              <option>Rondônio</option>
              <option>Roraima</option>
              <option>Santa Catarina</option>
              <option>São Paulo</option>
              <option>Sergipe</option>
              <option>Tocantins</option>
            </select>
            <div class="invalid-feedback">
              Por favor selecione um estado.
            </div>
        </div> 

        <br>

        <button class="btn-primeiro w-100" type="submit">Salvar Alterações</button>
      </form>
    </div>
  </div>
</main>

<footer class="my-5 pt-5 text-body-secondary text-center text-small">
  <p class="mb-1 txtcor1">&copy; 2017–2023 Company Name</p>
  <ul class="list-inline">
    <li class="list-inline-item "><a class="txtcor1" href="index.html">Home</a></li>
    <li class="list-inline-item"><a class="txtcor1" href="#">Terms</a></li>
    <li class="list-inline-item"><a class="txtcor1" href="#">Support</a></li>
  </ul>
</footer>
</div>
<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
<script src="checkout.js"></script>
</body>
</html>
