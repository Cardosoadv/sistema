<!DOCTYPE html>
<html lang="pt-BR"><!--begin::Head-->
<head>
<title>Sistema | Vendas</title><!--begin::Primary Meta Tags-->    
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
                    <h3 class="mb-0">Vendas</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Vendas
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
          <div class="d-flex justify-content-end">
            <a data-bs-toggle="modal" data-bs-target="#modal_revenue" class="btn btn-success mb-2" onclick="reveneus.novaVenda()">Nova Venda</a>
          </div>
          <?php
          if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
          }
          ?>
          <div class="mt-3">
            <table class="table table-bordered" id="accounts-list">
              <thead>
                <tr>
                  <th>Venda</th>
                  <th>Data de Vencimento</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($revenues) : ?>
                  <?php foreach ($revenues as $revenue) : ?>
                    <tr>
                      <td><?php echo $revenue['revenue']; ?></td>
                      <td><?php echo $revenue['due_dt']; ?></td>
                      <td>
                        <a class="btn btn-primary btn-sm" onclick="revenues.edit(<?= $revenue['id'] ?>)">Editar</a>
                        <a href="<?php echo base_url('revenues/delete/' . $revenue['id']); ?>" class="btn btn-danger btn-sm">Deletar</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Fim -->
            
        </div><!--end::Container-->
    </div><!--end::App Content-->
</main><!--end::App Main-->




    <?= $this->include('template/modals/change_user_img.php') ?>
    <?= $this->include('template/modals/revenues.php') ?>
    <?= $this->include('template/footer') ?>
    </body><!--end::Body-->

</html>
