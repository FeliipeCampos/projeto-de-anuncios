<?php

include_once '../conexao.php';

// verifica se foi enviado um POST com os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // recupera os dados do formulário
  $nome = $_POST['nome'];
  $sobrenome = $_POST['sobrenome'];
  $data_nascimento = $_POST['data_nascimento'];
  $email = $_POST['email'];
  $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
  $data_criacao = date('Y-m-d H:i:s');
  $tipo = "usuario";

  // verifica se o email já existe no banco de dados
  $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $count);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if ($count > 0) {
    // exibe mensagem de erro
    echo 'Erro ao inserir usuário: email já existente';
  } else {
    // prepara a query SQL para inserir o usuário no banco de dados
    $sql = "INSERT INTO usuarios (nome, sobrenome, data_nascimento, email, senha, data_criacao, tipo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    // bind dos parâmetros
    mysqli_stmt_bind_param($stmt, "sssssss", $nome, $sobrenome, $data_nascimento, $email, $senha, $data_criacao, $tipo);

    // executa a query
    if (mysqli_stmt_execute($stmt)) {
      // redireciona para a página de sucesso
      header('Location: ../index.php');
    } else {
      // exibe mensagem de erro
      echo 'Erro ao inserir usuário: ' . mysqli_stmt_error($stmt);
    }

    // fecha o statement
    mysqli_stmt_close($stmt);
  }
}

?>
