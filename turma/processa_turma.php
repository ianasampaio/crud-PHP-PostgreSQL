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


// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// die();

if (!empty($_POST)) {
  // Está chegando dados por POST e então posso tentar inserir no banco
  // Obter as informações do formulário ($_POST)
  // Verificar se estou tentando INSERIR (CAD) / ALTERAR (ALT) / EXCLUIR (DEL)
  if ($_POST['enviarDados'] == 'CAD') { // CADASTRAR!!!
    try {
      // Preparar as informações
        // Montar a SQL (pgsql)
        $sql = "INSERT INTO turma
                  (numero_disciplina, nome_disciplina, semestre, ano, professor)
                VALUES
                  (:numero_disciplina, :nome_disciplina, :semestre, :ano, :professor)";

        // Preparar a SQL (pdo)
        $stmt = $pdo->prepare($sql);

        // Definir/organizar os dados p/ SQL
        $dados = array(
          ':numero_disciplina' => $_POST['numero_disciplina'],
          ':nome_disciplina' => strtolower($_POST['nome_disciplina']),
          ':semestre' => strtolower($_POST['semestre']),
          ':ano' => $_POST['ano'],
          ':professor' => strtolower($_POST['professor'])
        );

        // Tentar Executar a SQL (INSERT)
        // Realizar a inserção das informações no BD (com o PHP)
        if ($stmt->execute($dados)) {
          header("Location: turma.php?msgSucesso=turma cadastrado com sucesso!");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
        header("Location: turma.php?msgErro=Falha ao cadastrar turma..");
    }
  }
  elseif ($_POST['enviarDados'] == 'ALT') { // ALTERAR!!!
    /* Implementação do update aqui.. */
    // Construir SQL para update
    try {
      $sql = "UPDATE
                turma
              SET
                semestre = :semestre,
                ano = :ano,
                professor = :professor
              WHERE
                identificacao_turma = :identificacao_turma";

      $stmt = $pdo->prepare($sql);

      // Definir dados para SQL
      $dados = array(
        ':identificacao_turma' => $_POST['identificacao_turma'],
        ':semestre' => strtolower($_POST['semestre']),
        ':ano' => $_POST['ano'],
        ':professor' => strtolower($_POST['professor'])
      );

      // Executar SQL
      if ($stmt->execute($dados)) {
        header("Location: turma.php?msgSucesso=Alteração realizada com sucesso!!");
      }
      else {
        header("Location: turma.php?msgErro=Falha ao ALTERAR turma..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: turma.php?msgErro=Falha ao ALTERAR turma..");
    }

  }
  elseif ($_POST['enviarDados'] == 'DEL') { // EXCLUIR!!!
    /** Implementação do excluir aqui.. */
    // identificacao_turma ok
    // e-mail usuário logado ok
    try {
      $sql = "DELETE FROM turma WHERE identificacao_turma = :identificacao_turma";
      $stmt = $pdo->prepare($sql);

      $dados = array(':identificacao_turma' => $_POST['identificacao_turma']);

      if ($stmt->execute($dados)) {
        header("Location: turma.php?msgSucesso=turma excluída com sucesso!!");
      }
      else {
        header("Location: turma.php?msgSucesso=Falha ao EXCLUIR turma..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: turma.php?msgSucesso=Falha ao EXCLUIR turma..");
    }
  }
  else {
    header("Location: turma.php?msgErro=Erro de acesso (Operação não definida).");
  }
}
else {
  header("Location: ../login/index_logado.php?msgErro=Erro de acesso.");
}
die();

// Redirecionar para a página inicial (index_logado) c/ mensagem erro/sucesso
 ?>