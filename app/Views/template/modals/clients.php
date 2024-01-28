<!-- Inicio do Modal -->
<div class="modal fade" id="modal_cliente" name="modal_cliente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cadastrar Clientes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_cliente" name="form_cliente" action="<?= site_url('/clients/adicionar') ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" class="form-control" value="">


                    <div class="form-row">
                        <div class="form-group col">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control">
                        </div>


                        <div class="form-group col">
                            <label>Telefone</label>
                            <input type="text" name="celular" class="form-control" data-inputmask='"mask": "(99) 99999-9999"' data-mask>
                        </div>

                    </div>
                    <div class="form-row">

                        <div class="form-group col">
                            <label>E-mail</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="form-group col">
                            <label>Data de Aquisição</label> 
                            <input type="text" name="landed_at" class="form-control">
                        </div>

                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- Fim do Modal -->