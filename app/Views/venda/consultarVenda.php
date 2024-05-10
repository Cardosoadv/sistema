<!DOCTYPE html>
<html lang="pt-BR"><!--begin::Head-->

<head>
  <title>Conselhos | Consulta Venda</title><!--begin::Primary Meta Tags-->
  <?= $this->include('template/header') ?>
</head><!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"><!--begin::App Wrapper-->
  <div class="app-wrapper">
    <?= $this->include('template/nav') ?>
    <?= $this->include('template/sidebar') ?>

    <!--begin::App Main-->
    <main class="app-main"><!--begin::App Content Header-->
      <div class="app-content-header"><!--begin::Container-->
        <div class="container-fluid"><!--begin::Row-->
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Consulta Venda</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                Consulta Venda
                </li>
              </ol>
            </div>
          </div><!--end::Row-->
        </div><!--end::Container-->
      </div><!--end::App Content Header--><!--begin::App Content-->
      <div class="app-content"><!--begin::Container-->
        <div class="container-fluid"><!--begin::Row-->

          <!-- Início -->
          <div class="container mt-4">

            <?php
            if (isset($_SESSION['msg'])) {
              echo '<div class="callout callout-info">';
              echo $_SESSION['msg'];
              echo '</div>';
            }
            ?>

            <div class="mt-3"><!-- inicio formulário -->

            <form method="post" id="form_venda" name="form_venda" action="<?= site_url('/vendas/atualizar/').$venda['id_venda']?>" enctype="multipart/form-data">
                <input type="hidden" name="id_venda" class="form-control" value="<?= $venda['id_venda']?>">


                  <div class="form-group">
                    <label>Venda</label>
                    <input type="text" name="venda" class="form-control" value="<?= $venda['venda']?>">
                  </div>
                <div class="row mt-3">
                  <div class="form-group col-3">
                    <label>Data de Vencimento</label>
                    <input type="date" name="vencimento_dt" class="form-control"  value="<?= $venda['vencimento_dt']?>">
                  </div>

                  <div class="form-group col-3">
                    <label>Valor</label>
                    <input type="number"  step="0.01" name="valor" class="form-control" value="<?= $venda['valor']?>">
                  </div>

                  <div class="form-group col-3">
                    <label>Categoria</label>
                    <input type="text" name="categoria" class="form-control"  value="<?= $venda['categoria']?>">
                  </div>

                  <div class="form-group col-3">
                    <label>Fornecedor</label>
                    <input type="text" name="fornecedor" class="form-control"  value="<?= $venda['fornecedor']?>">
                  </div>

                </div>
                <div class="row mt-3">
                  
                  <div class="form-group">
                    <label>Comentários</label>
                    <textarea class="form-control" name="comentario" aria-label="Comentários"> <?= $venda['comentario']?></textarea>
                  </div>

                  <div class="form-group col-3 mt-3">
                    <label>Rateio</label>
                    <input type="text" name="rateio" class="form-control"  value="<?= $venda['rateio']?>">
                  </div>

                </div>
            </div>
            <div class="mt-3">
              <button type="submit" class="btn btn-primary">Salvar</button>
              </form>

              <a href="<?= site_url('/vendas/') ?>" class="btn btn-secondary right">Cancelar</a>
            </div><!-- fim formulário -->

          </div>
          <!-- Fim -->

        </div><!--end::Container-->
      </div><!--end::App Content-->
    </main><!--end::App Main-->




    <?= $this->include('template/modals/change_user_img.php') ?>
    <?= $this->include('template/footer') ?>
</body><!--end::Body-->

</html>