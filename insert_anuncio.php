<?php

include_once 'conexao.php';

// verifica se foi enviado um POST com os dados do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // recupera os dados do formulário
  $titulo = ucfirst($_POST['titulo']);
  $descricao = nl2br($_POST['descricao']);
  $valor_minimo = $_POST['valor_minimo'];
  $valor_maximo = $_POST['valor_maximo'];
  $categoria = $_POST['categoria'];
  $id_anuncio = $_POST['id_anuncio'];
  $id_criador = $_POST['id_criador']; 

  // define o valor padrão para o campo "status"
  $status = 'analise';

  $sql = "INSERT INTO anuncios (titulo, descricao, valor_minimo, valor_maximo, categoria, status, data_criacao, id_criador) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)"; // adiciona a coluna 
  $stmt = mysqli_prepare($conn, $sql);

  mysqli_stmt_bind_param($stmt, "ssddssi", $titulo, $descricao, $valor_minimo, $valor_maximo, $categoria, $status, $id_criador); // adiciona o bind para id_criador

  // executa a query
  if (mysqli_stmt_execute($stmt)) {
    // redireciona para a página de sucesso
    header('Location: index.php');
  } else {
    // exibe mensagem de erro
    echo 'Erro ao inserir anúncio: ' . mysqli_stmt_error($stmt);
  }

  // fecha o statement
  mysqli_stmt_close($stmt);
}
?>
