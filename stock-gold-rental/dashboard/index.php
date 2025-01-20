<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-gold.php') ;
include('../function/check-login.php');

check_login($conn);
?>

<div class="wrapper">
<?php 
    include('../../template/header.php');
    include('../template/aside.php');
?>

<?php
  $data = array(
    "conn" => $conn,
    "supplier_type" => "",
    "product_no" => "",
    "product_cate" => "",
    "weight" => "",
    "detail" => "",
    "import_date" => "",
    "cost_id" => "",
    "cost" => "",
    "sale_date" => "",
    "price_id" => "",
    "price" => "",
    "status" => "",
    "id" => ""
  );

  $stock = new Stock_gold($data);
  $query = $stock->get_dashboard();
?>

<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<style>
    .btn-tb{
        margin-right: 5px;
    }

    table thead tr{
        background: #ffdf0036;
    }
</style>

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
                    <span class="info-box-text">ยอดจำนำทั้งหมด</span>
                    <span class="info-box-number"><?=$query['warehouse']?></span>
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
                    <span class="info-box-text">ค้างต่อดอก(คน)</span>
                    <span class="info-box-number"><?=$query['stock']?></span>
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
                    <span class="info-box-text">ยอดเก็บดอกเดือนนี้</span>
                    <span class="info-box-number"><?=$query['sale']['list_sale']?></span>
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
                    <span class="info-box-text">ยอดที่เก็บได้เดือนนี้</span>
                    <span class="info-box-number"><?=number_format($query['sale']['sum_sale'],2)?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

</body>
</html>

