<?php
require_once('../conexao/conectaBD.php');

session_start();

if (empty($_SESSION)) {
  // Significa que as variáveis de SESSAO não foram definidas.
  // Não poderia acessar aqui.
  header("Location: ../index.php?msgErro=Você precisa se autenticar no sistema.");
  die();
}
$alunos = array();

$sql = "SELECT * FROM aluno ORDER BY numero_aluno ASC";

try {
  $stmt = $pdo->prepare($sql);

  if ($stmt->execute()) {
    // Execução da SQL Ok!!
    $alunos = $stmt->fetchAll();
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
    <title>aluno</title>
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
        <h2 class="title">Alunos</h2>
      </div>
    </div>
    <div class="container">
      <a href="cad_aluno.php" class="btn btn-primary">Cadastrar Aluno(a)</a>
      <a href="busca_aluno.php" class="btn btn-primary">Pesquisar</a>
      <a href="../login/index_logado.php" class="btn btn-danger">Voltar</a>
    </div>  
    
    <?php if (!empty($alunos)) { ?>
      <!-- Aqui que será montada a tabela com a relação de aluno!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Nome</th>
              <th scope="col">Ano Curricular</th>
              <th scope="col">Curso</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($alunos as $a) { ?>
              <tr>
                <th scope="row"><?php  echo $a['numero_aluno'];?></th>
                <td><?php echo ucwords($a['nome']); ?></td>
                <td><?php echo $a['tipo_aluno']; ?></td>
                <td><?php echo ucwords($a['curso']); ?></td>
                <td>
                  <a href="alt_aluno.php?numero_aluno=<?php echo $a['numero_aluno']; ?>" class="btn btn-warning">Alterar</a>
                  <a href="del_aluno.php?numero_aluno=<?php echo $a['numero_aluno']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>



  </body>
</html>

<?php

/*<label >aluno:</label> 
              <select name="alunos" id="alunos" >
              <?php if(count($alunos)){
                   foreach ($alunos as $res) {?>
                    <option value="<?php echo $res['numero_aluno'];?>" >
                     <?php echo $res['nome_aluno'];?></option> <?php } } ?> 
                    </select>*/
