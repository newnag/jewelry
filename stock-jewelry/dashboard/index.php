<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/sale-jewelry.php') ;

check_login($conn);
?>

<div class="wrapper">
<?php 
    include('../../template/header.php');
    include('../template/aside.php');
?>

<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    .btn-tb{
        margin-right: 5px;
    }

    /* .main-sidebar{
      min-height: 1100px!important;
    } */

    table thead tr{
        background: #003366;
        color: #fff;
    }

    .head-table{
      background-color: #003366;
    }
</style>

<?php
  $data = array(
    "conn" => $conn,
    "barcode" => "",
    "cus_id" => "",
    "item_id" => "",
    "sale_date" => "",
    "sale_price" => "",
    "sell_price" => "",
    "point_received" => "",
  );

  $dashboard = new Sale_jewelry($data);
  $get_dashboard = $dashboard->get_dashboard();
  $get_sale_dashboard = $dashboard->get_sale_dashboard();

  // print_r($get_sale_dashboard);
?>

<div class="content-wrapper" style="min-height:800px">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-box"></i></span>
    
                <div class="info-box-content">
                <span class="info-box-text">สต็อกทั้งหมด</span>
                <span class="info-box-number"><?=$get_dashboard['order_stock']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-shopping-cart"></i></span>
    
                <div class="info-box-content">
                <span class="info-box-text">ยอดสั่งทำ</span>
                <span class="info-box-number"><?=$get_dashboard['order_total']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-cart-arrow-down"></i></span>
    
                <div class="info-box-content">
                <span class="info-box-text">ขายทั้งหมด</span>
                <span class="info-box-number"><?=$get_dashboard['sale']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-money-bill"></i></span>
    
                <div class="info-box-content">
                <span class="info-box-text">ยอดค้างสั่งทำ</span>
                <span class="info-box-number"><?=$get_dashboard['order_outstand']?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>

        <div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">รายการขายล่าสุด</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive table-hover">
              <table class="table m-0">
                <thead>
                    <tr>
                    <th>รหัสสินค้า</th>
                    <th>น้ำหนัก</th>
                    <th>ประเภท</th>
                    <th>วันที่ขาย</th>
                    <th>ราคาขาย</th>
                    <th>ลูกค้า</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    for($i=0;$i<count($get_sale_dashboard);$i++){
                      echo "
                        <tr>
                            <td>".$get_sale_dashboard[$i]['product_no']."</td>
                            <td>".$get_sale_dashboard[$i]['weight']." กรัม</td>
                            <td>".$get_sale_dashboard[$i]['type_name']."</td>
                            <td>".$get_sale_dashboard[$i]['sale_date']."</td>
                            <td>".number_format($get_sale_dashboard[$i]['sale_price'],2)."</td>
                            <td>".$get_sale_dashboard[$i]['fullname']."</td>
                        </tr>
                      ";
                    }
                  ?>  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>


</body>
</html>

