<?php
require_once('../conexao/conectaBD.php');
// Definir o BD (e a tabela)
// Conectar ao BD (com o PHP)

/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/

if (!empty($_POST)) {
  // Está chegando dados por POST e então posso tentar inserir no banco
  // Obter as informações do formulário ($_POST)
  if ($_POST['enviarDados'] == 'CAD') {
    try {
      // Preparar as informações
        // Montar a SQL (pgsql)
        $sql = "INSERT INTO aluno
                  (nome, tipo_aluno, curso)
                VALUES
                  (:nome, :tipo_aluno, :curso)";
  
        // Preparar a SQL (pdo)
        $stmt = $pdo->prepare($sql);
  
        // Definir/organizar os dados p/ SQL
        $dados = array(
          ':nome' => strtolower($_POST['nome']),
          ':tipo_aluno' => $_POST['tipo_aluno'],
          ':curso' => strtolower($_POST['curso'])
        );
  
        // Tentar Executar a SQL (INSERT)
        // Realizar a inserção das informações no BD (com o PHP)
        if ($stmt->execute($dados)) {
          header("Location: aluno.php?msgSucesso=Cadastro realizado com sucesso!");
        }
    } catch (PDOException $e) {
        die($e->getMessage());
        header("Location: aluno.php?msgErro=Falha ao cadastrar...");
    }
  }
  elseif ($_POST['enviarDados'] == 'ALT') { // ALTERAR!!!
    /* Implementação do update aqui.. */
    // Construir SQL para update
    try {
      $sql = "UPDATE
                aluno
              SET
                nome = :nome,
                tipo_aluno = :tipo_aluno,
                curso = :curso
              WHERE
                numero_aluno = :numero_aluno";

      $stmt = $pdo->prepare($sql);

      // Definir dados para SQL
      $dados = array(
        ':numero_aluno' => $_POST['numero_aluno'],
        ':nome' => strtolower($_POST['nome']),
        ':tipo_aluno' => $_POST['tipo_aluno'],
        ':curso' => strtolower($_POST['curso'])
      );

      // Executar SQL
      if ($stmt->execute($dados)) {
        header("Location: aluno.php?msgSucesso=Alteração realizada com sucesso!!");
      }
      else {
        header("Location: aluno.php?msgErro=Falha ao ALTERAR aluno..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: aluno.php?msgErro=Falha ao ALTERAR aluno..");
    }

  }
  elseif ($_POST['enviarDados'] == 'DEL') { // EXCLUIR!!!
    /** Implementação do excluir aqui.. */
    // numero_aluno ok
    // e-mail usuário logado ok
    try {
      $sql = "DELETE FROM aluno WHERE numero_aluno = :numero_aluno";
      $stmt = $pdo->prepare($sql);

      $dados = array(':numero_aluno' => $_POST['numero_aluno']);

      if ($stmt->execute($dados)) {
        header("Location: aluno.php?msgSucesso=Aluno excluído com sucesso!!");
      }
      else {
        header("Location: aluno.php?msgSucesso=Falha ao EXCLUIR aluno..");
      }
    } catch (PDOException $e) {
      //die($e->getMessage());
      header("Location: aluno.php?msgSucesso=Falha ao EXCLUIR aluno..");
    }
  }
  else {
    header("Location: aluno.php?msgErro=Erro de acesso (Operação não definida).");
  }
}
else {
  header("Location: ../index.php?msgErro=Erro de acesso.");
}
die();

// Redirecionar para a página inicial (login) c/ mensagem erro/sucesso
 ?>