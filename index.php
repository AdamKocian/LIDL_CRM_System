<!DOCTYPE html>
<html lang="en">
<link rel="shortcut icon" type="image/png" href="assets\uploads\Favicon.svg" />
<?php session_start() ?>
<?php
if (!isset($_SESSION['login_id']))
  header('location:login.php');
include 'db_connect.php';
ob_start();
if (!isset($_SESSION['system'])) {

  $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
  foreach ($system as $k => $v) {
    $_SESSION['system'][$k] = $v;
  }
}
ob_end_flush();

include 'header.php'
?>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <?php include 'topbar.php' ?>
    <?php include 'sidebar.php' ?>

    <!-- Obsah stránky -->
    <div class="content-wrapper">
      <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
      <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
      <!-- Nadpis -->
      <div class="content-header">
        <div class="container-fluid">

          <!-- Hlavný obsah -->
          <section class="content">
            <div class="container-fluid">
              <?php
              $page = isset($_GET['page']) ? $_GET['page'] : 'home';
              if (!file_exists($page . ".php")) {
                include '404.html';
              } else {
                include $page . '.php';
              }
              ?>
            </div>
          </section>
          <div class="modal fade" id="confirm_modal" role='dialog'>
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Potvrdenie</h5>
                </div>
                <div class="modal-body">
                  <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id='confirm' onclick="">Pokračovať</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Zatvoriť</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="uni_modal" role='dialog'>
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"></h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Uložiť</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušiť</button>
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="uni_modal_right" role='dialog'>
            <div class="modal-dialog modal-full-height  modal-md" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="fa fa-arrow-right"></span>
                  </button>
                </div>
                <div class="modal-body">
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="viewer_modal" role='dialog'>
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content">
                <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
                <img src="" alt="">
              </div>
            </div>
          </div>
        </div>

        <!-- Bočný panel -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <!-- Päta -->
        <footer class="main-footer">
          <strong>&copy; 2021 Adam Kocian & Dávid Krátky </strong>
          <div class="float-right d-none d-sm-inline-block">
            <b><?php echo $_SESSION['system']['name'] ?> Verzia 1.4</b>
          </div>
        </footer>
      </div>
      <?php include 'footer.php' ?>
</body>

</html>