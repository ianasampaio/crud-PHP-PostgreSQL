<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}

$historico_escolar = array();
$sql = "SELECT * FROM historico_escolar ORDER BY numero_aluno ASC";
  try {
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute()) {
      // Execução da SQL Ok!!
      $historico_escolar = $stmt->fetchAll();

      /*
      echo '<pre>';
      print_r($historico_escolar);
      echo '</pre>';
      die();*/
      
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
        <h2 class="title">Histórico</h2>
      </div>
    </div>
    <div class="container">
      <a href="index_cad_historico.php" class="btn btn-primary">Inserir nota</a>
      <a href="pesquisa_historico.php" class="btn btn-primary">Pesquisar</a>
      <a href="../login/index_logado.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($historico_escolar)) { ?>
      <!-- Aqui que será montada a tabela com a relação de historico_escolar!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Nome</th>
              <th scope="col">Numero turma</th>
              <th scope="col">Disciplina</th>
              <th scope="col">Nota</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($historico_escolar as $h) { ?>
              <tr>
                <th scope="row"><?php echo $h['numero_aluno']; ?></th>
                <td><?php echo ucwords($h['nome_aluno']); ?></td>
                <td><?php echo ucwords($h['identificacao_turma']); ?></td>
                <td><?php echo ucwords($h['nome_disciplina']); ?></td>
                <td><?php echo $h['nota']; ?></td>
                <td>
                    <a href="alt_historico.php?numero_aluno=<?php echo $h['numero_aluno']; ?>&identificacao_turma=<?php echo $h['identificacao_turma']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_historico.php?numero_aluno=<?php echo $h['numero_aluno']; ?>&identificacao_turma=<?php echo $h['identificacao_turma']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>



  </body>
</html>

