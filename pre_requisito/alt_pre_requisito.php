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

$num_pre_requisito = $_GET['numero_pre_requisito'];
$num_disciplina = $_GET['numero_disciplina'];

if (!empty($_GET['numero_pre_requisito']) and !empty($_GET['numero_disciplina'])) {

  $sql = "SELECT * FROM pre_requisito as pr
          WHERE pr.numero_pre_requisito = :numero_pre_requisito 
          AND pr.numero_disciplina = :numero_disciplina";
  try {
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(':numero_pre_requisito' => $_GET['numero_pre_requisito'],
                         ':numero_disciplina' => $_GET['numero_disciplina']));
    
    if ($stmt->rowCount() == 1) {
        $result = $stmt->fetchAll();
        $result = $result[0]; 
    }
    else {
      header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
      die();
    }
  } catch (PDOException $e) {
    header("Location: ../login/index_logado.php?msgErro=Falha ao obter registro no banco de dados.");
    //die($e->getMessage());

  }
}
else {
  header("Location: ../login/index_logado.php?msgErro=Você não tem permissão para acessar esta página");
  die();
}

$disciplinas = array();
$sql = "SELECT * FROM disciplina ORDER BY numero_disciplina ASC";
try {
  $stmt = $pdo->prepare($sql);
  if ($stmt->execute()) {
    $disciplinas = $stmt->fetchAll();
  }
  else {
    die("Falha ao executar a SQL.. #1");
  }

} catch (PDOException $e) {
  die($e->getMessage());
}
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alterar Pré-requisito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  </head>
  <body>

    <div class="container">
      <h1>Alterar Pré-requisito</h1>
      <form action="processa_pre_requisito.php" method="post">
      <!-- <input type="hidden" name="num_pre_requisito" id="num_pre_requisito" value="<?php echo $num_pre_requisito;?>"> -->
      <input type="hidden" name="numero_disciplina" id="numero_disciplina" value="<?php echo $num_disciplina;?>">

        <div class="col-4">
          <label for="nome_disciplina">Disciplina</label>
          <input type="text" name="nome_disciplina" id="nome_disciplina" class="form-control" value="<?php echo ucwords($result['nome_disciplina']);?>" readonly>
        </div>

        <div class="col-4">
          <label for="num_pre_requisito">Número Pré-requisito</label>
          <input type="number" name="num_pre_requisito" id="num_pre_requisito" class="form-control" value="<?php echo $result['numero_pre_requisito'];?>" readonly>
        </div>

        <br />
        <h3>Selecione um pré-requisito:</h3>

        <?php if (!empty($disciplinas)) { ?>
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
                  <?php foreach ($disciplinas as $d) { ?>
                  <tr>
                    <th scope="row"><?php echo $d['numero_disciplina']; ?></th>
                    <td><?php echo ucwords($d['nome_disciplina']); ?></td>
                    <td><?php echo $d['creditos']; ?></td>
                    <td><?php echo ucwords($d['departamento']); ?></td>
                    <td>
                        <input type = "checkbox" id = "numero_pre_requisito" name = "numero_pre_requisito" value = "<?php echo $d['numero_disciplina'];?>">                    
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        <?php } ?>

        <br />
        
        <button type="submit" name="enviarDados" class="btn btn-primary" value="ALT">Alterar</button>
        <a href="pre_requisito.php" class="btn btn-danger">Cancelar</a>

      </form>
    </div>
  </body>
</html>