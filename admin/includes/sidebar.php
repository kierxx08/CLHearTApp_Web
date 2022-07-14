<?php
include('../assets/db_conn.php');
include('scripts/get.php');
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">CLHEAR TApp</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../image/no_img.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo get_userfullnamr($conn,$_SESSION['user_id']) ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="index.php" class="nav-link <?php if (isset($index)) {
                                                echo "active";
                                              } ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="announcement.php" class="nav-link <?php if (isset($announcement)) {
                                                        echo "active";
                                                      } ?>">
            <i class="nav-icon fas fa-solid fa-bullhorn"></i>
            <p>
              Announcement
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="cultural_resources.php" class="nav-link <?php if (isset($cultural_resources)) {
                                                              echo "active";
                                                            } ?>">
            <i class="nav-icon fas fa-map-marked-alt"></i>
            <p>
              Resources
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="users.php" class="nav-link <?php if (isset($users)) {
                                                echo "active";
                                              } ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="setting.php" class="nav-link <?php if (isset($setting)) {
                                                echo "active";
                                              } ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Setting
            </p>
          </a>
        </li>



      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>