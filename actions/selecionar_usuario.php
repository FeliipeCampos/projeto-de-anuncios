<?php
// Estabelece a conexão com o banco de dados
include_once('../conexao.php');
 
// Recebe o ID da candidatura a ser selecionada
$id_candidatura = $_GET['id'];

// Obtém o ID do anúncio associado a esta candidatura
$sql = "SELECT id_anuncio FROM candidaturas WHERE id = $id_candidatura";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$id_anuncio = $row['id_anuncio'];

// Atualiza o status da candidatura para "selecionado"
$sql = "UPDATE candidaturas SET status = 'selecionado' WHERE id = $id_candidatura";
 
// Executa a query de atualização
if (mysqli_query($conn, $sql)) {
    // Redireciona o usuário para a página chat.php?id=$id_anuncio
    header("Location: ../chat.php?id=$id_anuncio");
    exit;
} else {
    echo "Erro ao selecionar a candidatura: " . mysqli_error($conn);
}
 
// Fecha a conexão com o banco de dados
mysqli_close($conn);
?>
