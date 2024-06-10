<?php
include 'conexao.php';

session_start();

// Verifica se a variável 'id' está presente na URL
if (isset($_GET['id'])) {
    // Captura o valor da variável 'id' da URL
    $id = $_GET['id'];    
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minhas candidaturas</title>
  <!-- Conexões para o Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <!-- Conexões para o jQuery DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <?php include 'header.php';?>
    <main class="container mt-4">
    <?php
        // Consulta à tabela candidaturas com base no id_usuario
        $query = "SELECT id_anuncio, data_hora, status FROM candidaturas WHERE id_usuario = $id";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            // Se houver resultados na consulta
            echo '
            <div class="table-responsive">
                <table id="tabela-anuncios" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Data da Candidatura</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>';

            while ($row = mysqli_fetch_assoc($result)) {
                $id_anuncio = $row['id_anuncio'];
                $data_hora = $row['data_hora'];
                $status = $row['status'];

                // Consulta à tabela anuncios com base no id_anuncio obtido
                $query_anuncio = "SELECT titulo FROM anuncios WHERE id = $id_anuncio";
                $result_anuncio = mysqli_query($conn, $query_anuncio);
                $row_anuncio = mysqli_fetch_assoc($result_anuncio);
                $titulo = $row_anuncio['titulo'];

                // Exibição dos resultados na tabela
                echo "<tr>
                        <td><strong>$titulo</strong></td>
                        <td>$data_hora</td>
                        <td>$status</td>
                    </tr>";
            }

            echo '</tbody>
                </table>
    ';
        } else {
            echo "Nenhum resultado encontrado."; 
        }

        mysqli_close($conn); 
        ?>
        </div>
    </main>
    <script>
        $(document).ready(function() {
        $('#tabela-anuncios').DataTable({
            // Configurações de idioma, se necessário
            language: {
            url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json'
            },
            // Configurações de filtro de pesquisa
            searching: true,
            // Configurações de paginação
            paging: true,
            // Configurações de ordenação
            ordering: true
        });
        });
    </script>
</body>
</html>
