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
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                    </div><!-- fim da primeira linha formulário -->
                    <!-- Inicio segunda linha formulário --><div class="row">
                      
                        <div class="form-group col-6">
                            <label>Telefone</label>
                            <input type="text" name="celular" class="form-control" data-inputmask='"mask": "(99) 99999-9999"' data-mask>
                        </div>

                        <div class="form-group col-6">
                            <label>Data de Aquisição</label> 
                            <input type="text" name="landed_at" class="form-control">
                        </div>

                    </div><!-- fim da segunda linha formulário -->
            </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" name="close" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- Fim do Modal -->