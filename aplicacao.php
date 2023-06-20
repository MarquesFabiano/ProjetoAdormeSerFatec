<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo "Opaaa, você não está logado. <a href='index.php'>Faça o login clicando aqui!</a>";
  exit;
}

$userID = $_SESSION['user_id'];

require_once 'conexao.php';
$databaseObj = new Database($host, $username, $password, $database);
$databaseObj->connect();

// Buscar dados do usuário no banco de dados
$query = "SELECT * FROM usuarios WHERE id = $userID";
$result = $databaseObj->executeQuery($query);

if ($result->num_rows === 1) {
  $usuario = $result->fetch_assoc();

  $id = $usuario['id'];
  $nome = $usuario['nome'];
  $email = $usuario['email'];
  $duracaoSono = $usuario['duracao_sono'];

  // Calculando a idade
  $dataNascimento = new DateTime($usuario['idade']);
  $dataAtual = new DateTime();
  $intervalo = $dataAtual->diff($dataNascimento);
  $idade = $intervalo->y;

  // chama função  para calcular a media de sono de geral
  $mediaSono = null;
  $query = "SELECT calcular_media_duracao_sono() AS resultado";
  $result = $databaseObj->executeQuery($query);

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $mediaSono = $row['resultado'];
  }
}

?>


<!doctype html>
<html lang="pt-br" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>PI</title>



  <link rel="stylesheet" type="text/css" href="headers.css">

  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="w-auto p-3 bgcor9">
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="film" viewBox="0 0 16 16">
      <path
        d="M0 1a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V1zm4 0v6h8V1H4zm8 8H4v6h8V9zM1 1v2h2V1H1zm2 3H1v2h2V4zM1 7v2h2V7H1zm2 3H1v2h2v-2zm-2 3v2h2v-2H1zM15 1h-2v2h2V1zm-2 3v2h2V4h-2zm2 3h-2v2h2V7zm-2 3v2h2v-2h-2zm2 3h-2v2h2v-2z" />
    </symbol>

    <symbol id="joystick" viewBox="0 0 16 16">
      <path
        d="M10 2a2 2 0 0 1-1.5 1.937v5.087c.863.083 1.5.377 1.5.726 0 .414-.895.75-2 .75s-2-.336-2-.75c0-.35.637-.643 1.5-.726V3.937A2 2 0 1 1 10 2z" />
      <path
        d="M0 9.665v1.717a1 1 0 0 0 .553.894l6.553 3.277a2 2 0 0 0 1.788 0l6.553-3.277a1 1 0 0 0 .553-.894V9.665c0-.1-.06-.19-.152-.23L9.5 6.715v.993l5.227 2.178a.125.125 0 0 1 .001.23l-5.94 2.546a2 2 0 0 1-1.576 0l-5.94-2.546a.125.125 0 0 1 .001-.23L6.5 7.708l-.013-.988L.152 9.435a.25.25 0 0 0-.152.23z" />
    </symbol>

    <symbol id="music-note-beamed" viewBox="0 0 16 16">
      <path
        d="M6 13c0 1.105-1.12 2-2.5 2S1 14.105 1 13c0-1.104 1.12-2 2.5-2s2.5.896 2.5 2zm9-2c0 1.105-1.12 2-2.5 2s-2.5-.895-2.5-2 1.12-2 2.5-2 2.5.895 2.5 2z" />
      <path fill-rule="evenodd" d="M14 11V2h1v9h-1zM6 3v10H5V3h1z" />
      <path d="M5 2.905a1 1 0 0 1 .9-.995l8-.8a1 1 0 0 1 1.1.995V3L5 4V2.905z" />
    </symbol>

    <symbol id="files" viewBox="0 0 16 16">
      <path
        d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
    </symbol>

    <symbol id="image-fill" viewBox="0 0 16 16">
      <path
        d="M.002 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-12a2 2 0 0 1-2-2V3zm1 9v1a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12zm5-6.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0z" />
    </symbol>

    <symbol id="trash" viewBox="0 0 16 16">
      <path
        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
      <path fill-rule="evenodd"
        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
    </symbol>

    <symbol id="question-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
      <path
        d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
    </symbol>

    <symbol id="arrow-left-short" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z" />
    </symbol>

    <symbol id="arrow-right-short" viewBox="0 0 16 16">
      <path fill-rule="evenodd"
        d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
    </symbol>
  </svg>
  <main>
    <div class="container py-4">
      <div class="py-5 text-center txtcor1">
        <img class="d-block mx-auto mb-4 rounded-circle" src="imagem/logo1.png" alt="" width="92" height="77">
      </div>


      <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-5 fw-bold">Seus dados de sono!</h1>
          <div class="col-md-8.fs-4">
            <strong>ID:</strong>
            <?php echo $id; ?><br>
            <strong>Nome:</strong>
            <?php echo $nome; ?><br>
            <strong>Email:</strong>
            <?php echo $email; ?><br>
            <strong>Idade:</strong>
            <?php echo $idade; ?><br>
            <strong>Duração do sono:</strong>
            <?php echo $duracaoSono; ?><br>
            <strong>A média de duração do sono dos nossos usuarios é:</strong>
            <?php echo $mediaSono; ?><br>
            <p class="col-md-8.fs-4"></p>
          </div>
          <p class="col-md-8 fs-4"></p>
          <button class="btn btn-primary btn-lg" type="button" onclick="receberNotificacoes()">Receba
            notificações!</button>
        </div>
      </div>

      <div class="row align-items-md-stretch">
        <div class="col-md-6">
          <div class="h-100 p-5 text-bg-dark rounded-3">
            <img class="d-block mx-auto mb-4" src="imagem/imagem.png" alt="" width="90%" height="90%" id="teste">
          </div>
        </div>
        <div class="col-md-6">
          <div class="h-100 p-5 bgcor6 rounded-3">


            <ul class="dropdown-menu d-block position-static mx-0 shadow w-220px " data-bs-theme="dark">
              <h5 class="text-center txtcor1">Links interessantes para te ajudar a dormir melhor</h5>
              <br>
              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center"
                  href="http://biton.uspnet.usp.br/espaber/?materia=a-importancia-de-dormir-bem" target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#files" />
                  </svg>
                  <h7 class="txtcor1">A importância de dormir bem</h7>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center"
                  href="https://www.scielo.br/j/rbp/a/vpFsp6ThNQqLSPDCkThKS3q/" target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#files" />
                  </svg>
                  <h7 class="txtcor1">O que pode causar sonolência excessiva?</h7>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center"
                  href="https://proaes.ufra.edu.br/images/CartilhaHigiene_do_SonoPsis-1.pdf" target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#files" />
                  </svg>
                  <h7 class="txtcor1">Cartilha sobre higiene do sono</h7>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center" href="https://www.netflix.com/title/81328827"
                  target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#film" />
                  </svg>
                  <h7 class="txtcor1">Headspace - Guia para Dormir Melhor</h7>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center " href="https://youtu.be/G7On00RWvAk"
                  target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#music-note-beamed" />
                  </svg>
                  <h7 class="txtcor1">ASMR</h7>
                </a>
              </li>
              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center" href="https://youtu.be/G-n3IKnGI5U"
                  target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#music-note-beamed" />
                  </svg>
                  <h7 class="txtcor1">Som de Chuva</h7>
                </a>
              </li>

              <li>
                <a class="dropdown-item d-flex gap-2 align-items-center"
                  href="https://www.youtube.com/live/VnTogGNWvIo?feature=share" target="_blank">
                  <svg class="bi" width="26" height="26">
                    <use xlink:href="#music-note-beamed" />
                  </svg>
                  <h7 class="txtcor1">Sono Profundo 1Hz Frequência Delta</h7>
                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>

      <footer class="my-5 pt-5 text-body-secondary text-center text-small">

        <ul class="list-inline">
          <button class="btn btn-outline-light border"><a href="logout.php">Logout</a></button>
          <button class="btn btn-outline-light border" type="button"
            onclick="window.location.href='atualizar_dados.php'">Atualize seus dados!</button>

        </ul>
      </footer>
    </div>
  </main>
  <script>

    var duracaoSono = "<?php echo $duracaoSono; ?>";
    var idade = <?php echo $idade; ?>;

    var mensagem = "Você tem " + idade + " anos e está dormindo por " + duracaoSono + " horas.";

    if (idade >= 14 && idade <= 17) {
      if (duracaoSono < 7) {
        mensagem += " Cuidado! Você está entre os 72% da população brasileira que sofre com distúrbios do sono. A qualidade do sono está diretamente ligada à qualidade de vida do ser humano. Enquanto dormimos, nosso organismo realiza funções extremamente importantes: fortalecimento do sistema imunológico, secreção e liberação de hormônios, consolidação da memória, entre outras. Porém, a falta de tempo de descanso aliada aos inúmeros distúrbios noturnos que atingem boa parte da população, o desempenho dessas funções fica prejudicado. Durante o dia, até a hora de você dormir, nós vamos ajudá - lo com algumas dicas e lembretes importantes para iniciar uma jornada rumo à saúde através do sono.";
      } else if (duracaoSono > 10) {
        mensagem += "Cuidado! Você está entre os 72% da população brasileira que sofre de distúrbios do sono. Sabe aquela frase clichê que diz que tudo em excesso faz mal? Aposto que você já ouviu isso da sua avó, da sua tia ou da sua mãe. E elas estavam todas certas. Tudo em excesso realmente faz mal, até o sono. É importante investigar as causas secundárias do seu sono excessivo, para isso é muito importante procurar um médico. Lembre-se, se o sono excessivo acontece em momentos pontuais, é perfeitamente normal. Na sessão documentos você encontrará um artigo científico que explica melhor as possíveis causas do sono excessivo.  Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para iniciar uma jornada rumo à saúde através do sono ";
      } else {
        mensagem += "Você está entre os 28% da população que não sofre com algum distúrbio relacionado ao sono! A qualidade do sono está diretamente ligada à qualidade de vida do ser humano. Enquanto dormimos, nosso organismo realiza funções extremamente importantes: fortalecimento do sistema imunológico, secreção e liberação de hormônios, consolidação da memória, entre outras. Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para que você possa melhorar ainda mais a qualidade do seu sono!";
      }
    } else if (idade >= 18 && idade <= 39) {
      if (duracaoSono < 7) {
        mensagem += "Cuidado! Você está entre os 72% da população brasileira que sofre com distúrbios do sono. A qualidade do sono está diretamente ligada à qualidade de vida do ser humano. Enquanto dormimos, nosso organismo realiza funções extremamente importantes: fortalecimento do sistema imunológico, secreção e liberação de hormônios, consolidação da memória, entre outras. Porém, a falta de tempo de descanso aliada aos inúmeros distúrbios noturnos que atingem boa parte da população, o desempenho dessas funções fica prejudicado.Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para iniciar uma jornada rumo à saúde através do sono.";
      } else if (duracaoSono > 9) {
        mensagem += " Cuidado! Você está entre os 72% da população brasileira que sofre de distúrbios do sono. Sabe aquela frase clichê que diz que tudo em excesso faz mal? Aposto que você já ouviu isso da sua avó, da sua tia ou da sua mãe. E elas estavam todas certas. Tudo em excesso realmente faz mal, até o sono. É importante investigar as causas secundárias do seu sono excessivo, para isso é muito importante procurar um médico. Lembre-se, se o sono excessivo acontece em momentos pontuais, é perfeitamente normal. Na sessão documentos você encontrará um artigo científico que explica melhor as possíveis causas do sono excessivo. Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para iniciar uma jornada rumo à saúde através do sono. ";
      } else {
        mensagem += "Você está entre os 28% da população que não sofre com algum distúrbio relacionado ao sono! A qualidade do sono está diretamente ligada à qualidade de vida do ser humano. Enquanto dormimos, nosso organismo realiza funções extremamente importantes: fortalecimento do sistema imunológico, secreção e liberação de hormônios, consolidação da memória, entre outras.  Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para que você possa melhorar ainda mais a qualidade do seu sono!";
      }
    } else if (idade >= 40 && idade <= 64) {
      if (duracaoSono < 7) {
        mensagem += " Cuidado! Você está entre os 72% da população brasileira que sofre com distúrbios do sono. A qualidade do sono está diretamente ligada à qualidade de vida do ser humano. Enquanto dormimos, nosso organismo realiza funções extremamente importantes: fortalecimento do sistema imunológico, secreção e liberação de hormônios, consolidação da memória, entre outras. Porém, a falta de tempo de descanso aliada aos inúmeros distúrbios noturnos que atingem boa parte da população, o desempenho dessas funções fica prejudicado. Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para iniciar uma jornada rumo à saúde através do sono. ";
      } else if (duracaoSono > 8) {
        mensagem += " Cuidado! Você está entre os 72% da população brasileira que sofre de distúrbios do sono. Sabe aquela frase clichê que diz que tudo em excesso faz mal? Aposto que você já ouviu isso da sua avó, da sua tia ou da sua mãe. E elas estavam todas certas. Tudo em excesso realmente faz mal, até o sono. É importante investigar as causas secundárias do seu sono excessivo, para isso é muito importante procurar um médico. Lembre-se, se o sono excessivo acontece em momentos pontuais, é perfeitamente normal. Na sessão documentos você encontrará um artigo científico que explica melhor as possíveis causas do sono excessivo.  Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para iniciar uma jornada rumo à saúde através do sono. ";
      } else {
        mensagem += "Você está entre os 28% da população que não sofre com algum distúrbio relacionado ao sono! A qualidade do sono está diretamente ligada à qualidade de vida do ser humano. Enquanto dormimos, nosso organismo realiza funções extremamente importantes: fortalecimento do sistema imunológico, secreção e liberação de hormônios, consolidação da memória, entre outras.  Durante o dia, até a hora de você dormir, nós vamos ajudá-lo com algumas dicas e lembretes importantes para que você possa melhorar ainda mais a qualidade do seu sono!  ";
      }

    }  else {
        mensagem += "O processamento de idade ainda está em desenvolvimento em nosso Site!"
      }

    var paragrafo = document.querySelector(".col-md-8.fs-4");
    paragrafo.textContent = mensagem;


    function checkBedtime() {
      var dataHoje = new Date();
      var horaAtual = dataHoje.getHours();
      var minutosAtuais = dataHoje.getMinutes();

      if (horaAtual === 10 && minutosAtuais === 22) {
        if ('Notification' in window) {
          Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
              var notification = new Notification('Hora de dormir!', {
                body: 'Chega de celular por hoje, hein!! Antes de dormir fique longe das telas pelo menos meia hora antes de dormir, substitua o seu celular por um livro, algo que te de sono mais rapidamente',
              });
            }
          });
        }
      }
    }

    // teste para permissão de notificação assim que entrar na sala
    if ('Notification' in window) {
      Notification.requestPermission();
    }

    checkBedtime(); // Verificar hora quando abre o site

    setInterval(checkBedtime, 60000); // a cada minuto, ve a hora

    function receberNotificacoes() {
      if ('Notification' in window) {
        Notification.requestPermission().then(function (permission) {
          if (permission === 'granted') {
            alert('Permissão concedida para receber notificações!');
          } else if (permission === 'denied') {
            alert('Permissão negada para receber notificações. Você pode alterar isso nas configurações do seu navegador.');
          }
        });
      } else {
        alert('Seu navegador não suporta notificações.');
      }
    }


  </script>
</body>

</html>