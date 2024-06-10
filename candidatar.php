<?php
// Inclui o arquivo de conexão com o banco de dados
include 'conexao.php';

// Define o fuso horário para Brasília
date_default_timezone_set('America/Sao_Paulo');

// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario'])) {
  // Se não estiver logado, redireciona para a página de login
  header('Location: login/index.php');
  exit;
}

// Recupera o ID do usuário a partir da sessão
$id_usuario = $_SESSION['usuario']['id'];

// Verifica se foi enviado um formulário de candidatura
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Recupera os dados do formulário
  $quantidade_dias = $_POST['quantidade_dias'];
  $preco = $_POST['preco'];
  $id_anuncio = $_GET['id_anuncio'];

  // Obtém a data e hora atual
  $data_hora = date('Y-m-d H:i:s');

  // Insere os dados na tabela "candidaturas" com a data e hora atual e status como "analise"
  $sql = "INSERT INTO candidaturas (id_anuncio, id_usuario, tempo, valor, data_hora, status) VALUES ('$id_anuncio', '$id_usuario', '$quantidade_dias', '$preco', '$data_hora', 'analise')";
  mysqli_query($conn, $sql);

  // Redireciona o usuário de volta para a página do anúncio
  header("Location: anuncio.php?id=$id_anuncio");
  exit;
}
?>