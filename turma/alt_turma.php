<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

// echo "Estou logado";
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
// die();

$turma = array();

// Verificar se está chegando a informação (identificacao_turma) pelo $_GET
if (!empty($_GET['identificacao_turma'])) {

    // Buscar as informações do anúncio a ser alterado (no banco de dados)
  $sql = "SELECT * FROM turma WHERE identificacao_turma = :identificacao_turma";
  try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(':identificacao_turma' => $_GET['identificacao_turma']));
    
    if ($stmt->rowCount() == 1) {
        // Registro obtido no banco de dados
        $result = $stmt->fetchAll();
        $result = $result[0]; // Informações do registro a ser alterado
  
        
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';
        
        // die();
  
    }
    else {
    //die("Não foi encontrado nenhum registro para id_anuncio = " . $_GET['id_anuncio'] . " e e-mail = " . $_SESSION['email']);
    header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
    die();
    }


  } catch (PDOException $e) {
    header("Location: ../login/index_logado.php?msgErro=Falha ao obter registro no banco de dados.");
    //die($e->getMessage());

  }
}
else {
  // Se entrar aqui, significa que $_GET['identificacao_turma'] está vazio
  header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
  die();
}
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alterar Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
      <h1>Alterar Turma</h1>
      <form action="processa_turma.php" method="post">
      <input type="hidden" name="identificacao_turma" id="identificacao_turma" value="<?php echo $result['identificacao_turma'];?>">


        <div class="col-4">
          <label for="numero_disciplina">Número disciplina</label>
          <input type="number" name="numero_disciplina" id="numero_disciplina" class="form-control" value="<?php echo $result['numero_disciplina'];?>" readonly>
        </div>

        <div class="col-4">
          <label for="nome_disciplina">Nome disciplina</label>
          <input type="text" name="nome_disciplina" id="nome_disciplina" class="form-control" value="<?php echo ucwords($result['nome_disciplina']);?>" readonly>
        </div>

        <div class="col-4">
          <label for="semestre">Semestre</label>
          <input type="text" name="semestre" id="semestre" class="form-control" value="<?php echo ucwords($result['semestre']);?>">
        </div>

        <div class="col-4">
          <label for="ano">Ano</label>
          <input type="number" name="ano" id="ano" class="form-control" value="<?php echo $result['ano'];?>">
        </div>

        <div class="col-4">
          <label for="professor">Professor(a)</label>
          <input type="text" name="professor" id="professor" class="form-control" value="<?php echo ucwords($result['professor']);?>">
        </div>

        <br />

        <button type="submit" name="enviarDados" class="btn btn-primary" value="ALT">Alterar</button>
        <a href="turma.php" class="btn btn-danger">Cancelar</a>

      </form>
    </div>
  </body>
</html>