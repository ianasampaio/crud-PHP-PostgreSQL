<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

$matricula = array();
$sql = "SELECT * FROM matricula as m 
        INNER JOIN turma as t ON m.identificacao_turma = t.identificacao_turma
        INNER JOIN aluno as a ON m.numero_aluno = a.numero_aluno
        ORDER BY m.numero_aluno ASC";
  try {
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
      $matricula = $stmt->fetchAll();
      
    }
    else {
      die("Falha ao executar a SQL.. #1");
    }

  } catch (PDOException $e) {
    die($e->getMessage());
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Histórico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <?php if (!empty($_GET['msgErro'])) { ?>
        <div class="alert alert-warning" role="alert">
          <?php echo $_GET['msgErro']; ?>
        </div>
      <?php } ?>

      <?php if (!empty($_GET['msgSucesso'])) { ?>
        <div class="alert alert-success" role="alert">
          <?php echo $_GET['msgSucesso']; ?>
        </div>
      <?php } ?>
    </div>

    <div class="container">
      <div class="col-md-11">
        <h2 class="title">Inserir Notas</h2>
      </div>
    </div>
    <div class="container">
      <a href="historico.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($matricula)) { ?>
      <!-- Aqui que será montada a tabela com a relação de matricula!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero aluno</th>
              <th scope="col">Aluno</th>
              <th scope="col">Numero turma</th>
              <th scope="col">Disciplina</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($matricula as $m) { ?>
              <tr>
                <th scope="row"><?php echo $m['numero_aluno']; ?></th>
                <td><?php echo ucwords($m['nome']); ?></td>
                <td><?php echo $m['identificacao_turma']; ?></td>
                <td><?php echo ucwords($m['nome_disciplina']); ?></td>
                <td>
                    <a href="cad_historico.php?
                    numero_aluno=<?php echo $m['numero_aluno']; ?>
                    &nome=<?php echo $m['nome']; ?>
                    &identificacao_turma=<?php echo $m['identificacao_turma']; ?>"
                    class="btn btn-warning">Inserir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>


  </body>
</html>

