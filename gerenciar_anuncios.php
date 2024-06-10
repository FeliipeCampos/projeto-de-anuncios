<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciar anuncios</title>
  <!-- Conexões para o Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- Conexões para o jQuery DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <?php
    include 'conexao.php';
    session_start();

    if (session_status() === PHP_SESSION_ACTIVE && isset($_SESSION['id'])) {
      $id_usuario = $_SESSION['id'];
      // Restante do código que usa $id_usuario
    } else {

    }
  ?>
</head>
<body>
  <?php include 'header.php'; ?>
  <main class="container mt-4 mb-4">
    <?php
    // Consulta à tabela anuncios para listar os anúncios criados pelo usuário
    $query = "SELECT anuncios.id, anuncios.titulo, anuncios.status, 
              COUNT(candidaturas.id) AS candidaturas, 
              (SELECT COUNT(*) FROM candidaturas 
              WHERE id_anuncio = anuncios.id AND status = 'selecionado') AS selecionados 
              FROM anuncios LEFT JOIN candidaturas 
              ON anuncios.id = candidaturas.id_anuncio 
              WHERE anuncios.id_criador = $id_usuario 
              GROUP BY anuncios.id";
    $result = mysqli_query($conn, $query);

    // Verifica se há resultados na consulta
    if (mysqli_num_rows($result) > 0) {
        // Exibição dos resultados em cards
        echo '<div class="row">';
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $titulo = $row['titulo'];
            $status = $row['status'];
            $candidaturas = $row['candidaturas'] ? $row['candidaturas'] : 0; // Trata o caso em que não há candidaturas para o anúncio
            $selecionados = $row['selecionados'] ? $row['selecionados'] : 0; // Trata o caso em que não há candidatos selecionados

            // Utiliza a função CASE para decidir qual link exibir no botão "Gerenciar"
            $link = $selecionados > 0 ? "chat.php?id=$id" : "meu_anuncio.php?id=$id";
            $texto = $selecionados > 0 ? "Iniciar chat" : "Gerenciar";

            echo '<div class="col-md-6 mb-4">
                    <div class="card">
                      <div class="card-header">
                        <h5 class="card-title">' . $titulo . '</h5>
                      </div>
                      <div class="card-body">
                        <p class="card-text"><strong>Estado atual:</strong> ' . $status . '</p>
                        <p class="card-text"><strong>Candidaturas:</strong> ' . $candidaturas . '</p>
                        <div class="text-center">
                          <a href="' . $link . '" class="btn btn-primary">' . $texto . '</a>
                        </div>
                      </div>
                    </div>
                  </div>';
        }
        echo '</div>';
    } else {
        echo "<div class='alert alert-info'>Nenhum anúncio criado.</div>"; // Mensagem caso não haja resultados na consulta
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conn);
  ?>
  </main>
</body>
</html>