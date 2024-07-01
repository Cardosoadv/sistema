<!DOCTYPE html>
<html lang="pt-BR"><!--begin::Head-->

<head>
  <title>Conselhos | Despesas</title><!--begin::Primary Meta Tags-->
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
              <h3 class="mb-0">Despesas</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                  Despesas
                </li>
              </ol>
            </div>
          </div><!--end::Row-->
        </div><!--end::Container-->
      </div><!--end::App Content Header--><!--begin::App Content-->
      <div class="app-content"><!--begin::Container-->
        <div class="container-fluid"><!--begin::Row-->

          <!-- Início -->

          <form action="" method="get">
            <div class="input-group mb-3">
              <input type="text" name="s" class="form-control" placeholder="Pesquisar..." aria-label="Pequisar" aria-describedby="button-addon2">
              <button class="btn btn-outline-secondary" type="submit" id="search">Pesquisar</button>
            </div>
          </form>

          <div class="container mt-4">
            <div class="d-flex justify-content-end">
              <a class="btn btn-success mb-2" href="<?php echo base_url('despesas/novo/'); ?>">Nova Despesa</a>
            </div>
            <?php
            if (isset($_SESSION['msg'])) {
              echo '<div class="callout callout-info">';
              echo $_SESSION['msg'];
              echo '</div>';
            }
            ?>

            <nav>
              <div class="nav nav-tabs" id="despesas-tab" role="tablist">
                <button class="nav-link active" id="despesas-todas-tab" data-bs-toggle="tab" data-bs-target="#despesas-todas" role="tab" aria-controls="despesas-todas" aria-selected="true">Todas as Despesas</button>
                <button class="nav-link" id="despesas-nao-vencidas-tab" data-bs-toggle="tab" data-bs-target="#despesas-nao-vencidas" role="tab" aria-controls="despesas-nao-vencidas" aria-selected="false">Não Vencidas</button>
                <button class="nav-link" id="despesas-vencidas-tab" data-bs-toggle="tab" data-bs-target="#despesas-vencidas" role="tab" aria-controls="despesas-vencidas" aria-selected="false">Vencidas</button>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="despesas-todas" role="tabpanel" aria-labelledby="despesas-todas">
                <div class="mt-3">
                  <table class="table table-bordered" id="despesas-list">
                    <thead>
                      <tr>
                        <th>Despesa</th>
                        <th>Data de Vencimento</th>
                        <th>Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($despesas) : ?>
                        <?php foreach ($despesas as $despesa) : ?>
                          <tr>
                            <td><?php echo $despesa['despesa']; ?></td>
                            <td><?php echo date_format(new DateTime($despesa['vencimento_dt']), "d/m/Y"); ?></td>
                            <td>
                              <a class="btn btn-primary btn-sm" href="<?php echo base_url('despesas/consultar/' . $despesa['id_despesa']); ?>">Editar</a>
                              <a href="<?php echo base_url('despesas/delete/' . $despesa['id_despesa']); ?>" class="btn btn-danger btn-sm">Deletar</a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div><!--Fim da Tab -->
              <div class="tab-pane fade" id="despesas-nao-vencidas" role="tabpanel" aria-labelledby="despesas-nao-vencidas">
                hgfjhfghjfjhfgjhfghjfgjhfgjh
              </div>
              <div class="tab-pane fade" id="despesas-vencidas" role="tabpanel" aria-labelledby="despesas-vencidas">
                <div class="mt-3">
                  <table class="table table-bordered" id="vencidas-list">
                    <thead>
                      <tr>
                        <th>Despesa</th>
                        <th>Data de Vencimento</th>
                        <th>Ação</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($vencidas) : ?>
                        <?php foreach ($vencidas as $vencida) : ?>
                          <tr>
                            <td><?php echo $vencida['despesa']; ?></td>
                            <td><?php echo date_format(new DateTime($vencida['vencimento_dt']), "d/m/Y"); ?></td>
                            <td>
                              <a class="btn btn-primary btn-sm" href="<?php echo base_url('despesas/consultar/' . $vencida['id_despesa']); ?>">Editar</a>
                              <a href="<?php echo base_url('despesas/delete/' . $vencida['id_despesa']); ?>" class="btn btn-danger btn-sm">Deletar</a>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div><!-- Fim da Tabulação -->
            <!-- Fim -->
          </div><!--end::Container-->
        </div><!--end::App Content-->
    </main><!--end::App Main-->

    <?= $this->include('template/modals/change_user_img.php') ?>
    <?= $this->include('template/footer') ?>
</body><!--end::Body-->

</html>