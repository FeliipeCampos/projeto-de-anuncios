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

  // Verifica se o ID foi passado como parâmetro na URL
  if(isset($_GET['id'])){
    $id = $_GET['id'];
  }
?>

</head>
<body>
  <?php include 'header.php'; ?>
    <main class="container mt-4 mb-4">
        <div class="row">
            <div class="col-md-4">
                <?php
                // Consulta à tabela anuncios para listar o anúncio correspondente ao ID
                $query = "SELECT id, titulo, SUBSTRING(descricao, 1, 50) AS descricao_reduzida, valor_minimo, valor_maximo, data_criacao, categoria, status FROM anuncios WHERE id = $id";
                $result = mysqli_query($conn, $query);

                // Verifica se há resultados na consulta
                if (mysqli_num_rows($result) > 0) :
                    // Exibição do resultado em um card
                    $row = mysqli_fetch_assoc($result);
                    $id = $row['id'];
                    $titulo = $row['titulo'];
                    $descricao = $row['descricao_reduzida'] . '...';
                    $valor_minimo = number_format($row['valor_minimo'], 2, ',', '.');
                    $valor_maximo = number_format($row['valor_maximo'], 2, ',', '.');
                    $data_criacao = date('d/m/Y', strtotime($row['data_criacao']));
                    $categoria = $row['categoria'];
                    $status = $row['status'];
                ?>
                <div class="card my-3 shadow-sm">
                    <div class="card-header">
                        <h4 class="card-title"><a href="anuncio.php?id=<?php echo $id; ?>"><?php echo $titulo; ?></a></h4>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $descricao; ?></p>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="card-text"><strong>Categoria:</strong> <?php echo $categoria; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="card-text"><strong>Data de criação:</strong> <?php echo $data_criacao; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <p class="card-text"><strong>Valor mínimo:</strong> R$ <?php echo $valor_minimo; ?></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="card-text"><strong>Valor máximo:</strong> R$ <?php echo $valor_maximo; ?></p>
                            </div>
                        </div>
                        <p class="card-text"><strong>Status:</strong> <?php echo $status; ?></p>
                    </div>
                </div>
                <?php else: ?>
                <div class='alert alert-danger'>Anúncio não encontrado.</div>
                <?php endif; ?>
            </div>

            <!-- DATA TABLE CANDIDATURAS -->
            <div class="col-md-8">
                <div class="my-3">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Candidaturas</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            $query = "SELECT c.id, c.valor, c.tempo, c.data_hora, u.id AS id_usuario, u.nome, u.sobrenome 
                                FROM candidaturas c 
                                INNER JOIN usuarios u ON c.id_usuario = u.id 
                                WHERE c.id_anuncio = $id";
                            $result = mysqli_query($conn, $query);

                            if (mysqli_num_rows($result) > 0):
                            ?>
                            <div class="table-responsive">
                                <table id="tabela-anuncios" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Candidato</th>
                                            <th>Proposta</th>
                                            <th>Prazo</th>
                                            <th>Data e hora da candidatura</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <?php 
                                            $id_candidatura = $row['id'];
                                            $id_usuario = $row['id_usuario'];
                                            $candidato_nome = $row['nome'] . ' ' . $row['sobrenome'];
                                            $candidatura_valor = number_format($row['valor'], 2, ',', '.');
                                            $candidatura_tempo = intval($row['tempo']);
                                            $candidatura_data_hora = $row['data_hora'];                                         
                                            ?>
                                            <tr>
                                                <td><a href="perfil.php?id=<?php echo $id_usuario; ?>" target="_blank"><?= $candidato_nome ?></a></td>
                                                <td>R$ <?= $candidatura_valor ?></td>
                                                <td><?= $candidatura_tempo ?> dia<?= $candidatura_tempo > 1 ? 's' : '' ?></td>
                                                <td><?= $candidatura_data_hora ?></td>
                                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $id_usuario; ?>">Selecionar</button></td>
                                            </tr>

                                            <!-- Modal -->
                                            <div class="modal fade" id="<?php echo $id_usuario; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Confirmação de seleção de usuário</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Você selecionou o candidato <strong><?php echo $candidato_nome; ?></strong> para realizar a tarefa.</p>
                                                            <p>Tem certeza de que deseja confirmar esta seleção?</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <a href="actions/selecionar_usuario.php?id=<?php echo $id_candidatura; ?>" class="btn btn-primary">Confirmar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info">Não há candidaturas para este anúncio ainda.</div>
                            <?php endif; ?>

                            <div class="my-3">
                                <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>
                            </div>

                            <?php mysqli_close($conn); ?>
                        </div>
                    </div>
                </div>
            </div>
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