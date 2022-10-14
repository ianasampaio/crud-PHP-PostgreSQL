<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Cadastrar Novo(a) Usuário(a)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>  
    <div class="container">
      <h1>Cadastrar Novo(a) Usuário(a)</h1>
      <form action="processa_usuario.php" method="post">
        <div class="col-4">
          <label for="nome_usuario">Nome Completo</label>
          <input type="text" name="nome_usuario" id="nome_usuario" class="form-control">
        </div>

        <div class="col-4">
          <label for="email">E-mail</label>
          <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="col-4">
          <label for="senha">Senha</label>
          <input type="password" name="senha" id="senha" class="form-control" required>
        </div><br>
        
        <button type="submit" name="enviarDados" class="btn btn-primary">Cadastrar</button>
        <a href="../index.php" class="btn btn-danger">Cancelar</a>
      </form>
    </div>
  </body>
</html>