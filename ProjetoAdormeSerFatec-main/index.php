
<!doctype html>
<html lang="pt-br" data-bs-theme="auto">

<head>
  <script src="assets/js/color-modes.js"></script>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>PI</title>

  <link rel="stylesheet" type="text/css" href="style.css">
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="w-auto p-3 bgcor9 d-flex flex-wrap justify-content-center">
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bgcor6 fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="imagem/logo1.png" width="100" height="76" alt="Logo">
          <span class="fs-4 txtcor1">Adorme.ser</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="cadastro.html">Cadastrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pricing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">FAQs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="form-signin w-100 m-auto bgcor6">
    <form action="login.php" method="POST">
      <h3 class="mb-3 fw-normal txtcor1">Faça seu login <img src="imagem/logo1.png" width="42" height="27" alt="Logo" />
      </h3>
      <div class="form-floating">
        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
        <label for="floatingInput">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" name="senha" placeholder="Password" required>
        <label for="floatingPassword">Senha</label>
      </div>
      <div class="checkbox mb-3 txtcor1">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>
      <button class="w-100 btn btn-lg btn-primary btn-primeiro my-2" type="submit">Logar</button>
      <a class="w-100 btn btn-lg btn-primary btn-segundo my-2" href="cadastro.html">Cadastre-se</a>
    </form>
  </main>

  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="checkout.js"></script>
</body>

</html>
