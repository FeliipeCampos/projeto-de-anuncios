<?php
// Inclui o arquivo de conexão com o banco de dados
require_once '../../conexao.php';

// Verifica se a variável "id" foi passada pela URL
if (isset($_GET['id'])) {
    // Captura o valor da variável "id"
    $id = $_GET['id'];

    // Monta a consulta SQL para excluir o anúncio
    $sql = "DELETE FROM anuncios WHERE id = $id";

    // Executa a consulta SQL
    if (mysqli_query($conn, $sql)) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Erro ao excluir o anúncio: " . mysqli_error($conn);
    }
} else {
    echo "ID do anúncio não foi informado.";
}
?>
