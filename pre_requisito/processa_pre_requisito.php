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
// print_r($_GET);
// echo '</pre>';
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// die();


if ((!empty($_GET) )or (!empty($_POST)) ) {
  
    $sql1 = "SELECT * FROM pre_requisito 
            WHERE 
            ((numero_pre_requisito = :numero_pre_requisito
            AND
            numero_disciplina = :numero_disciplina)
            OR
            (numero_pre_requisito = :numero_disciplina
            AND
            numero_disciplina = :numero_pre_requisito))
            OR
            (numero_disciplina = (SELECT numero_pre_requisito FROM pre_requisito 
                                    WHERE  numero_disciplina = :numero_pre_requisito) 
            AND numero_pre_requisito = :numero_disciplina)";
    
    try {
        $stmt = $pdo->prepare($sql1);

        $stmt->execute(array(':numero_pre_requisito' => $_GET['numero_pre_requisito'],
                                ':numero_disciplina' => $_GET['numero_disciplina']));

        if ($stmt->rowCount() == 1) {
            header("Location: pre_requisito.php?msgErro=Relação inválida!");
        }elseif ($_GET['enviarDados'] == 'CAD') { 
            $sql = "INSERT INTO pre_requisito
            (numero_pre_requisito, numero_disciplina, nome_pre_requisito, nome_disciplina)
            VALUES
            (:numero_pre_requisito, :numero_disciplina, :nome_pre_requisito, :nome_disciplina)";
            try { 
                $stmt = $pdo->prepare($sql);

                $dados = array(
                ':numero_pre_requisito' => $_GET['numero_pre_requisito'],
                ':numero_disciplina' => $_GET['numero_disciplina'],
                ':nome_pre_requisito' => $_GET['nome_pre_requisito'],
                ':nome_disciplina' => $_GET['nome_disciplina']
                );

                if ($stmt->execute($dados)) {
                    header("Location: pre_requisito.php?msgSucesso=Pré-requisito cadastrado com sucesso!");
                }
                else {
                    header("Location: pre_requisito.php?msgErro=Falha ao CADASTRAR pré-requisito..");
                }
            } catch (PDOException $e) {
                die($e->getMessage());
                header("Location: pre_requisito.php?msgErro=Falha ao cadastrar pré-requisito..");
            } 
        }elseif ($_POST['enviarDados'] == 'ALT') {
            $sql = "UPDATE
                    pre_requisito
                    SET
                    numero_pre_requisito = :numero_pre_requisito,
                    nome_pre_requisito = (SELECT nome_disciplina FROM disciplina WHERE  numero_disciplina = :numero_pre_requisito)
                    WHERE
                    numero_disciplina = :numero_disciplina
                    AND
                    numero_pre_requisito = :num_pre_requisito";

            try {
                $stmt = $pdo->prepare($sql);
        
                // Definir dados para SQL
                $dados = array(
                ':numero_disciplina' => $_POST['numero_disciplina'],
                ':numero_pre_requisito' => $_POST['numero_pre_requisito'],
                ':num_pre_requisito' => $_POST['num_pre_requisito']
                );
        
                // Executar SQL
                if ($stmt->execute($dados)) {
                header("Location: pre_requisito.php?msgSucesso=Alteração realizada com sucesso!!");
                }
                else {
                header("Location: pre_requisito.php?msgErro=Falha ao ALTERAR pré-requisito..1");
                }
            } catch (PDOException $e) {
                //die($e->getMessage());
                header("Location: pre_requisito.php?msgErro=Falha ao ALTERAR pré-requisito..2");
            }
        }elseif ($_POST['enviarDados'] == 'DEL') {
            try {
                $sql = "DELETE FROM pre_requisito 
                        WHERE 
                        numero_disciplina = :numero_disciplina
                        AND
                        numero_pre_requisito = :numero_pre_requisito";
        
                $stmt = $pdo->prepare($sql);
        
                $dados = array(':numero_disciplina' => $_POST['numero_disciplina'],
                               ':numero_pre_requisito' => $_POST['numero_pre_requisito']);
        
                if ($stmt->execute($dados)) {
                    header("Location: pre_requisito.php?msgSucesso=Pré-requisito excluída com sucesso!!");
                }
                else {
                    header("Location: pre_requisito.php?msgSucesso=Falha ao EXCLUIR pré-requisito..");
                }
            } catch (PDOException $e) {
            //die($e->getMessage());
            header("Location: pre_requisito.php?msgSucesso=Falha ao EXCLUIR pré-requisito..");
            }
        }else{
            header("Location: pre_requisito.php?msgErro=Erro de acesso (Operação não definida).");
        } 
    } catch (PDOException $e) {
        die($e->getMessage());
        header("Location: pre_requisito.php?msgErro=Falha ao cadastrar pré-requisito..");
    }
}
else {
  header("Location: ../login/index_logado.php?msgErro=Erro de acesso.");
}
die();

 ?>