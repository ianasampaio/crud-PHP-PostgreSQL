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
// print_r($_POST);
// echo '</pre>';
// die();
if (!empty($_POST)) {

    try {
      $nome_aluno = strtolower($_POST['nome']);

      $sql = "SELECT * FROM matricula as m 
              INNER JOIN turma as t ON m.identificacao_turma = t.identificacao_turma
              INNER JOIN aluno as a ON m.numero_aluno = a.numero_aluno
              WHERE a.nome LIKE '%$nome_aluno%'
              ORDER BY m.numero_aluno ASC";            
      $stmt = $pdo->prepare($sql);

      $stmt->execute();
      if ($stmt->rowCount() >= 1) {
          $result = $stmt->fetchAll();

        }
      } catch (PDOException $e) {
        die($e->getMessage());
        header("Location: ../login/index_logado.php?msgErro=Falha ao BUSCAR Disciplina..");
    }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Matricula</title>
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
        <h2 class="title">Matriculas</h2>
      </div>
    </div>
    <div class="container">
      <a href="matricula.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($result)) { ?>
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
              <?php foreach ($result as $r) { ?>
              <tr>
                <th scope="row"><?php echo $r['numero_aluno']; ?></th>
                <td><?php echo ucwords($r['nome']); ?></td>
                <td><?php echo $r['identificacao_turma']; ?></td>
                <td><?php echo ucwords($r['nome_disciplina']); ?></td>
                <td>
                    <a href="alt_matricula.php?numero_aluno=<?php echo $r['numero_aluno']; ?>&identificacao_turma=<?php echo $r['identificacao_turma']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_matricula.php?numero_aluno=<?php echo $r['numero_aluno']; ?>&identificacao_turma=<?php echo $r['identificacao_turma']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>
    <?php if (empty($result)) {?>
        <div class="container">
            <div class="col-md-11">
                <br />
                <p class="title">Não há registros.</p>
            </div>
        </div>
    <?php } ?>


  </body>
</html>

