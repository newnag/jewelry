<style>
  .logout-btn{
    position : absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
  }
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/gold/backend/dashboard/" class="brand-link">
      <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ฝากขายทอง</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>


      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="pages/examples/login-v2.html" class="nav-link">
                  <i class="fas fa-user"></i>
                  <p>ข้อมูลผู้ฝากขาย</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="pages/examples/login-v2.html" class="nav-link">
                  <i class="fas fa-calendar-alt"></i>
                  <p>รายการใกล้ครบกำหนด</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="pages/examples/login-v2.html" class="nav-link">
                  <i class="fas fa-ban"></i>
                  <p>รายการหลุดจำนำ</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="pages/examples/login-v2.html" class="nav-link">
                  <i class="fas fa-cog"></i>
                  <p>ตั้งค่าการใช้งาน</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="pages/examples/login-v2.html" class="nav-link">
                  <i class="fas fa-users"></i>
                  <p>ตั้งค่าผู้ดูแล</p>
                </a>
            </li>
        </ul>
      </nav>

    </div>

    <div class="logout-btn"><button type="button" class="btn btn-block btn-primary">ออกจากระบบ</button></div>
  </aside>