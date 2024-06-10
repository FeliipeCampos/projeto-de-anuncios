<div class="col-md-4">
    <div class="card mt-3 mt-md-0">
        <div class="card-body">
            <h5 class="card-title text-center mb-4">Relatório do Anúncio</h5>
            <ul class="list-unstyled">
                <li class="mb-3">
                    <strong>Número de pessoas candidatadas:</strong>
                    <span class="float-end"><?php echo intval($numPessoasCandidatadas); ?></span>
                </li>
                <li class="mb-3">
                    <strong>Média das propostas:</strong>
                    <span class="float-end">R$ <?php echo number_format($mediaPropostas, 2, ',', '.'); ?></span>
                </li>
                <li>
                    <strong>Média de tempo:</strong>
                    <span class="float-end"><?php echo intval($mediaTempo); ?> dias</span>
                </li>
            </ul>
        </div>
    </div>
</div>