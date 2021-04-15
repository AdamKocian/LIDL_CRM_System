  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">

      <a href="./" class="brand-link">
        <img style="display: block; margin-left: auto; margin-right: auto; width: 50%;" src="assets\uploads\Lidl_WHITE.svg" alt="Lidl logo">
      </a>

    </div>
    <div style="margin-top: 78px;" class="sidebar pb-4 mb-4">
      <nav class="mt-2 h-100">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat h-100" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item dropdown">
            <a href="./" class="nav-link nav-home">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Ovládací panel
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./" class="nav-link nav-home">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Domov</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./harmonogram/index.html" class="nav-link tree-item">
                  <!-- harmonogram.php -->
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Harmonogram</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link nav-edit_project nav-view_project">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                Tímy
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if ($_SESSION['login_type'] != 3) : ?>
                <li class="nav-item">
                  <a href="./index.php?page=new_team" class="nav-link nav-new_project tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Pridať tím</p>
                  </a>
                </li>
              <?php endif; ?>
              <li class="nav-item">
                <a href="./index.php?page=team_list" class="nav-link nav-project_list tree-item">
                  <i class="fas fa-angle-right nav-icon"></i>
                  <p>Zoznam tímov</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="./index.php?page=task_list" class="nav-link nav-task_list">
              <i class="fas fa-tasks nav-icon"></i>
              <p>Úlohy</p>
            </a>
          </li>
          <?php if ($_SESSION['login_type'] != 3) : ?>
            <li class="nav-item">
              <a href="./index.php?page=reports" class="nav-link nav-reports">
                <i class="fas fa-th-list nav-icon"></i>
                <p>Report</p>
              </a>
            </li>
          <?php endif; ?>
          <?php if ($_SESSION['login_type'] == 1) : ?>
            <li class="nav-item">
              <a href="#" class="nav-link nav-edit_user">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Používatelia
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Pridať používateľa</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Zoznam používateľov</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link tree-item">
                    <i class="fas fa-angle-right nav-icon"></i>
                    <p>Dovolenky</p>
                  </a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
          <li class="nav-item mt-auto">
            <a style="position: relative;">
          </li>
          <li class="nav-item">
            <a style="position: relative; padding-left: 26px; opacity: 0.5; margin-bottom: 10px;" href="ajax.php?action=logout" class="nav-link">
              <i class="fa fa-power-off"></i>
              <p>Odhlásiť sa</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
  <script>
    $(document).ready(function() {
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      if (s != '')
        page = page + '_' + s;
      if ($('.nav-link.nav-' + page).length > 0) {
        $('.nav-link.nav-' + page).addClass('active')
        if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
          $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
          $('.nav-link.nav-' + page).parent().addClass('menu-open')
        }

      }

    })
  </script>