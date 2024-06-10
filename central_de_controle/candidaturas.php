<?php
include '../conexao.php';

session_start();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuários</title>
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
            // Consulta à tabela candidaturas
            $query = "SELECT id, id_anuncio, id_usuario, valor, tempo, data_hora, status FROM candidaturas";
            $result = mysqli_query($conn, $query);

            // Verifica se há resultados na consulta
            if (mysqli_num_rows($result) > 0) {
                // Exibição dos resultados na tabela
                echo '
                <div class="table-responsive">
                    <table id="tabela-candidaturas" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID do anúncio</th>
                                <th>ID do usuário</th>
                                <th>Valor</th>
                                <th>Tempo</th>
                                <th>Data e Hora</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    <tbody>';
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $id_anuncio = $row['id_anuncio'];
                        $id_usuario = $row['id_usuario'];
                        $valor = $row['valor'];
                        $tempo = $row['tempo'];
                        $data_hora = $row['data_hora'];
                        $status = $row['status'];
                    
                        echo "<tr>
                                <td>$id</td>
                                <td>$id_anuncio</td>
                                <td>$id_usuario</td>
                                <td>R$ $valor</td>
                                <td>$tempo dias</td>
                                <td>$data_hora</td>
                                <td>$status</td>
                            </tr>";
                    }
                        
                echo '</tbody>
                    </table>
                </div>';
            } else {
                echo "Nenhum resultado encontrado."; // Mensagem caso não haja resultados na consulta
            }

            // Fecha a conexão com o banco de dados
            mysqli_close($conn);
        ?>
    </main>

    <script>
        $(document).ready(function() {
        $('#tabela-candidaturas').DataTable({
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
