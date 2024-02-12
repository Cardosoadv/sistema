<!-- Inicio do Modal -->
<div class="modal fade" id="modal_revenue" name="modal_revenue">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cadastrar Venda</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="revenues.close()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div> 
            <div class="modal-body">
                <form method="post" id="form_revenue" name="form_revenue" action="<?= site_url('/revenues/adicionar') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" class="form-control" value="">

                    <!-- Inicio primeira linha formulário --><div class="row">
                        <div class="form-group">
                            <label>Venda</label>
                            <input type="text" name="revenues" class="form-control">
                        </div>
                       
                    </div><!-- fim da primeira linha formulário -->
                    <!-- Inicio segunda linha formulário --><div class="row">
                    
                    <div class="form-group col">
                            <label>Data de Vencimento</label>
                            <input type="date" name="due_dt" class="form-control">
                        </div>

                       
                    <div class="form-group col">
                            <label>Valor</label>
                            <input type="currency" name="value" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label>Cliente</label> 
                            <?= $ClientsOption ?>
                        </div>

                        <div class="form-group col">
                            <label>Categoria</label> 
                            <?= $CategoryOption ?>
                        </div>

                    </div><!-- fim da segunda linha formulário -->
                    <div class="form-group form-row">
                            <label>Comentários</label>
                            <textarea name="comments"></textarea>
                            
                        </div>

            </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" name="close" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- Fim do Modal -->