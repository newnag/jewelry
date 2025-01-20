<style>
  /* .list-pad-left li{
    padding-left: .5em;
  } */

  .list-warehouse{
    background-color: #d9a82a!important;
    border-radius: 5px;
  }
  .list-warehouse li a{
    color: #951b1e!important;
  }
</style>

<?php
include('../../classes/type-product.php');

  $data_menu_type = array(
    "conn" => $conn,
    "type_name" => "",
    "cate_name" => "",
    "type_id" => "",
    "id" => ""
  );
  $type_menu = new Type_product($data_menu_type);
  $get_menutype = $type_menu->get_menu_type("1");
  $get_menutype_border = $type_menu->get_menu_type("5");

  // print_r($get_menutype);
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#951b1e">
    <!-- Brand Logo -->
    <a href="/stock-gold/dashboard/" class="brand-link" style="background:#07504b">
      <img src="../../asset/img/logo-gold.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="color: #d9a82a;">สต็อกทอง</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="#" class="nav-link" style="color: #d9a82a;">
                <i class="fas fa-coins"></i>
                <p>
                  คลังสินค้า
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview list-pad-left list-warehouse">
                <li class="nav-item">
                  <a href="../warehouse" class="nav-link">
                    <i class="fas fa-coins"></i>
                    <p>ข้อมูลทั้งหมด</p>
                  </a>
                </li>
                <?php
                  for($i=0;$i<count($get_menutype);$i++){
                    if($get_menutype[$i]['id'] != 31){
                      echo '
                        <li class="nav-item">
                          <a href="../warehouse/warehouse-table.php?type='.$get_menutype[$i]['id'].'" class="nav-link">
                            <i class="fas fa-coins"></i>
                            <p>'.$get_menutype[$i]['type_name'].'</p>
                          </a>
                        </li>
                      ';
                    }
                  }
                ?>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link" style="color: #d9a82a;">
                <i class="fas fa-coins"></i>
                <p>
                  สต็อกหน้าร้าน
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview list-pad-left list-warehouse">
                <li class="nav-item">
                  <a href="../stock" class="nav-link">
                    <i class="fas fa-coins"></i>
                    <p>ข้อมูลทั้งหมด</p>
                  </a>
                </li>
                <?php
                  for($i=0;$i<count($get_menutype);$i++){
                    if($get_menutype[$i]['id'] != 31){
                      echo '
                        <li class="nav-item">
                          <a href="../stock/warehouse-table.php?type='.$get_menutype[$i]['id'].'" class="nav-link">
                            <i class="fas fa-coins"></i>
                            <p>'.$get_menutype[$i]['type_name'].'</p>
                          </a>
                        </li>
                      ';
                    }
                  }
                ?>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link" style="color: #d9a82a;">
                <i class="fas fa-coins"></i>
                <p>
                กรอบพระ
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview list-pad-left list-warehouse">
                <li class="nav-item">
                  <a href="../border" class="nav-link">
                    <i class="fas fa-coins"></i>
                    <p>ข้อมูลทั้งหมด</p>
                  </a>
                </li>
                <?php
                  for($i=0;$i<count($get_menutype_border);$i++){
                    echo '
                        <li class="nav-item">
                          <a href="../border/border-table.php?type='.$get_menutype_border[$i]['id'].'" class="nav-link">
                            <i class="fas fa-coins"></i>
                            <p>'.$get_menutype_border[$i]['type_name'].'</p>
                          </a>
                        </li>
                    ';
                  }
                ?>
              </ul>
            </li>

            <!-- <li class="nav-item">
                <a href="../border" class="nav-link" style="color: #d9a82a;">
                  <i class="fas fa-coins"></i>
                  <p>กรอบพระ</p>
                </a>
            </li> -->

            <li class="nav-item">
                <a href="../barcode" class="nav-link" style="color: #d9a82a;">
                  <i class="fas fa-shopping-cart"></i>
                  <p>ระบบการขาย</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="../buying" class="nav-link" style="color: #d9a82a;">
                  <i class="fas fa-shopping-cart"></i>
                  <p>ระบบการรับซื้อ</p>
                </a>
            </li>

            <!-- <li class="nav-item">
                <a href="../barcode" class="nav-link">
                  <i class="fas fa-shopping-cart"></i>
                  <p>การขาย</p>
                </a>
            </li> -->
            
            <li class="nav-item">
                <a href="../report" class="nav-link" style="color: #d9a82a;">
                  <i class="fas fa-chart-bar"></i>
                  <p>สรุป / รายงาน</p>
                </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link" style="color: #d9a82a;">
                <i class="fas fa-cog"></i>
                <p>
                  การตั้งค่า
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../type-product" class="nav-link" style="color: #d9a82a;">
                    <i class="fas fa-folder"></i>
                    <p>หมวดหมู่/ประเภท</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="../supplier" class="nav-link" style="color: #d9a82a;">
                    <i class="fas fa-folder"></i>
                    <p>Supplier</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="../type-product-border" class="nav-link" style="color: #d9a82a;">
                    <i class="fas fa-folder"></i>
                    <p>หมวดหมู่/ประเภท กรอบพระ</p>
                  </a>
                </li>
              </ul>
            </li>
        </ul>
      </nav>

    </div>
  </aside>