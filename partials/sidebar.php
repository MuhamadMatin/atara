<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="home.php" class="brand-link">
    <img src="dist/img/ataralogo.png" alt="Atara Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">ATARA BATIK</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php
        include "connect.php";
        $nama = $_SESSION['username'];
        $sql = "SELECT `link_profile` FROM `master_user` WHERE `username`='$nama'";
        $hasil = mysqli_query($connection, $sql);
        $rowc = mysqli_fetch_array($hasil);
        // $linkimage = @$rowc[link_profile];
        if ($linkimage == "") {
          $linkimage = "dist/img/avatar4.png";
        }
        echo '<img src="' . $linkimage . '" class="img-circle elevation-2" alt="User Image">';
        ?>
      </div>
      <div class="info">
        <a href="#" class="d-block text-uppercase"><?php echo $_SESSION["profilename"] ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="home.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="pos.php" class="nav-link">
            <i class="nav-icon fas fa-solid fa-money-bill"></i>
            <p>POS</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-desktop"></i>
            <p>
              Monitoring
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="monitoring_stock.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="monitoring_stock_all.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Stock All</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="monitoring_pp.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <?php
                if ($_SESSION["role"] == "admin") {
                ?>
                  <p>Pembelian / Penjualan</p>
                <?php
                } else {
                ?>
                  <p>Penjualan</p>
                <?php
                }
                ?>
              </a>
            </li>
            <li class="nav-item">
              <a href="monitoring_nota.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Nota Jual</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="monitoring_booking.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Booking / Retur</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="monitoring_vc.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <?php
                if ($_SESSION["role"] == "admin") {
                ?>
                  <p>Vendor / Client</p>
                <?php
                } else {
                ?>
                  <p>Client</p>
                <?php
                }
                ?>
              </a>
            </li>
            <li class="nav-item">
              <a href="monitoring_returbeli_deleted.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Retur Beli/Deleted</p>
              </a>
            </li>

          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-database"></i>
            <p>
              Data Entry
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <?php
            if ($_SESSION["role"] == "admin") {
            ?>
              <li class="nav-item">
                <a href="data_entry_pembelian.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian</p>
                </a>
              </li>
            <?php
            }
            ?>
            <?php
            if ($_SESSION["role"] == "admin") {
            ?>
              <li class="nav-item">
                <a href="data_entry_penjualan.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penjualan</p>
                </a>
              </li>
            <?php
            }
            ?>
            <li class="nav-item">
              <a href="data_entry_pelunasan.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pelunasan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="data_entry_mockup.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Upload Mockup</p>
              </a>
            </li>
            <?php
            if ($_SESSION["role"] == "admin") {
            ?>
              <li class="nav-item">
                <a href="data_entry_vendor.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Vendor</p>
                </a>
              </li>
            <?php
            }
            ?>
            <li class="nav-item">
              <a href="data_entry_client.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Daftar Client</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="data_entry_booking.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="data_entry_retur.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Retur Penjualan</p>
              </a>
            </li>

          </ul>
        </li>
        <?php
        if ($_SESSION["role"] == "admin") {
        ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Master
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="master_toko.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Toko</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="master_merk.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Merk</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="master_jeniskain.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jenis Kain</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="master_ongkos.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ongkos Jahit</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="user.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>User Management</p>
            </a>
          </li>
        <?php
        } else { ?>
          <li class="nav-item">
            <a href="changepasswordtoko.php" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>Change Password</p>
            </a>
          </li>
        <?php }
        if ($_SESSION["role"] == "admin") {
        ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Report
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="report_summary.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summary Jenis Kain</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report_kode_kain.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Summary Kode Kain</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report_omzet_trending.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Omzet Trending</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="report_pembelian.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pembelian</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report_penjualan.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Penjualan</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report_client.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="report_omzet.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Omzet</p>
                </a>
              </li> -->
            </ul>
          </li>
        <?php
        } ?>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-crown"></i>
            <p>
              Atara Privilege
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="privilege_member.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Member</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="privilege_voucher.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Voucher</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>