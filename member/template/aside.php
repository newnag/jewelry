<style>
  .main-sidebar{
    background-color: #68a8a7;
  }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/member/dashboard/" class="brand-link" style="background-color: #f7a686;">
      <img src="../../asset/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ระบบสมาชิก</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: #68a8a7;">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column list-member" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="../membership" class="nav-link">
                  <i class="fas fa-user"></i>
                  <p>ข้อมูลสมาชิก</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="../history" class="nav-link">
                  <i class="fas fa-shopping-cart"></i>
                  <p>ประวัติการซื้อ</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="../history-reward" class="nav-link">
                  <i class="fas fa-gift"></i>
                  <p>ประวัติการแลกของ</p>
                </a>
            </li>

            <?php 
              if($_SESSION['role'] == 1){
                echo '
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fas fa-cog"></i>
                      <p>
                        ตั้งค่า
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview list-pad-left list-warehouse">
                      <li class="nav-item">
                          <a href="../admin" class="nav-link">
                            <i class="fas fa-user"></i>
                            <p>ตั้งค่าผู้ดูแลระบบ</p>
                          </a>
                      </li>

                      <li class="nav-item">
                          <a href="../reward" class="nav-link">
                            <i class="fas fa-gift"></i>
                            <p>ตั้งค่าของรางวัล</p>
                          </a>
                      </li>
                    </ul>
                  </li>
                ';
              }
            ?>

        </ul>
      </nav>

    </div>
  </aside>