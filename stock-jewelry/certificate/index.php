<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-jewelry-product.php') ;
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
      "type_build" => "",
      "stock_date" => "",
      "type_product" => "",
      "product_no" => "",
      "detail" => "",
      "size" => "",
      "weight" => "",
      "cost" => "",
      "cost_id" => "",
      "price_sale" => "",
      "price_id" => "",
      "sale_date" => "",
      "status_product" => "",
      "reuse_product" => "",
      "reuse_detail" => "",
      "id" => ""
    );
  
    ///////////////////////////////////////////////////////////////
    // query data
    $stock = new Stock_jewelry_product($data);
    $get_data = $stock->get();

    // print_r($get_data);
    ///////////////////////////////////////////////////////////////
?>

<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">


<style>
    .btn-tb{
      margin-right: 5px;
    }

    .tb-action{
      width: 220px;
    }

    .main-sidebar{
      min-height: 1100px!important;
    }

    tbody .child .dtr-details{
      min-width: 200px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ใบรับประกัน</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ใบรับประกัน</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" onclick="add_new()"><i class="fas fa-plus"></i> เพิ่มใบรับประกัน</button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-gold" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>เลขใบรับประกัน</th>
                            <th>ชื่อลูกค้า</th>
                            <th>รหัสสินค้า</th>
                            <th>วันที่</th>
                            <th>ใบเซอร์เพชร</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <td>2405650001</td>
                            <td>สมหมาย มั่นใจ</td>
                            <td>SKU0001</td>
                            <td>24/05/2565</td>
                            <td>C00001</td>
                            <td>
                              <div class="row">
                                <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" >ดู/แก้ไข</button></div>
                                <div class="col-auto"><button type="button" style="width:fit-content;" class="btn btn-block bg-gradient-danger btn-cus-w">ลบ</button></div>
                                <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-success btn-cus-w" >พิมพ์</button></div>
                              </div>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="js/stock.js"></script>

<script type="text/javascript">
  $(document).ready( function () {
    setTimeout(() => {
      $('#table-gold').DataTable({
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    }, 500);
    
  });

  function add_new(){
      location.href = "https://thavorn-jewelry.com/stock-jewelry/certificate/add.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-jewelry/certificate/edit.php?id=${id}`
  }
</script>

</body>
</html>

