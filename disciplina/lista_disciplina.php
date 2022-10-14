<?php
require_once('../conexao/conectaBD.php');
// Definir o BD (e a tabela)
// Conectar ao BD (com o PHP)

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
    $disciplinas = array();
        // Preparar as informações
          // Montar a SQL (pgsql)

          try {
            $nome = strtolower($_POST['nome_disciplina']);
            $sql = "SELECT * FROM disciplina WHERE nome_disciplina LIKE '%$nome%'";
            
            $stmt = $pdo->prepare($sql);

            // $dados = array(':nome_disciplina' => $_POST['nome_disciplina']);
            // var_dump($dados);
            $stmt->execute();
            if ($stmt->rowCount() >= 1) {
                // Registro obtido no banco de dados
                $result = $stmt->fetchAll();
                //$result = $result[0]; // Informações do registro a ser alterado
                // var_dump($result);
                /*
                echo '<pre>';
                print_r($result);
                echo '</pre>';*/
                
                //die();
          
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
    <title>Disciplina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
      <div class="col-md-11">
        <h2 class="title">Resultado</h2>
      </div>
    </div>
    <div class="container">
      <a href="disciplina.php" class="btn btn-danger">Voltar</a>
    </div>  
    <?php if (!empty($result)) { ?>
      <!-- Aqui que será montada a tabela com a relação de disciplina!! -->
      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Numero</th>
              <th scope="col">Nome</th>
              <th scope="col">Creditos</th>
              <th scope="col">Departamento</th>
            </tr>
          </thead>
          <tbody>
              <?php foreach ($result as $d) { ?>
                <tr>
                <th scope="row"><?php echo $d['numero_disciplina']; ?></th>
                <td><?php echo ucwords($d['nome_disciplina']); ?></td>
                <td><?php echo $d['creditos']; ?></td>
                <td><?php echo ucwords($d['departamento']); ?></td>
                <td>
                    <a href="alt_disciplina.php?numero_disciplina=<?php echo $d['numero_disciplina']; ?>" class="btn btn-warning">Alterar</a>
                    <a href="del_disciplina.php?numero_disciplina=<?php echo $d['numero_disciplina']; ?>" class="btn btn-danger">Excluir</a>
                </td>
              </tr>
              <!-- <?php var_dump($d['numero_diciplina']);?> -->
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
