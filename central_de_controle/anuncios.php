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
  <title>Anúncios</title>
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
        // Consulta à tabela anuncios
        $query = "SELECT id, titulo, descricao, valor_minimo, valor_maximo, data_criacao, categoria, status, id_criador FROM anuncios";
        $result = mysqli_query($conn, $query);

        // Verifica se há resultados na consulta
        if (mysqli_num_rows($result) > 0) {
            // Exibição dos resultados na tabela
            echo '
            <div class="table-responsive">
                <table id="tabela-anuncios" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Valor mínimo</th>
                            <th>Valor máximo</th>
                            <th>Data de criação</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>ID do criador</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                <tbody>';
                while ($row = mysqli_fetch_assoc($result)) {
                    $id = $row['id'];
                    $titulo = $row['titulo'];
                    $descricao = $row['descricao'];
                    $valor_minimo = $row['valor_minimo'];
                    $valor_maximo = $row['valor_maximo'];
                    $data_criacao = $row['data_criacao'];
                    $categoria = $row['categoria'];
                    $status = $row['status'];
                    $id_criador = $row['id_criador'];
                
                    echo "<tr>
                            <td>$id</td>
                            <td><a href='../anuncio.php?id=$id'><strong>$titulo</strong></a></td>
                            <td>$valor_minimo</td>
                            <td>$valor_maximo</td>
                            <td>$data_criacao</td>
                            <td>$categoria</td>
                            <td>$status</td>
                            <td>$id_criador</td>
                            <td>
                                <div class='dropdown'>
                                    <button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        Ação
                                    </button>
                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                        <a class='dropdown-item' href='actions/aprovar_anuncio.php?id=$id'>Aceitar</a>
                                        <a class='dropdown-item' href='actions/negar_anuncio.php?id=$id'>Negar</a>
                                    </div>
                                </div>
                            </td>
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
