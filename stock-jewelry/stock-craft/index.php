<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-jewelry-order.php') ;
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
    "paper_no" => "",
    "type_product" => "",
    "customer_id" => "",
    "customer_name" => "",
    "detail" => "",
    "order_date" => "",
    "estimate_price" => "",
    "deposit" => "",
    "price" => "",
    "cost" => "",
    "weight" => "",
    "size" => "",
    "supplier_body_id" => "",
    "supplier_body_name" => "",
    "supplier_body_lot" => "",
    "supplier_body_weight" => "",
    "supplier_body_cost" => "",
    "supplier_body_type" => "",
    "supplier_loose" => "",
    "id" => ""
  );
  
  ///////////////////////////////////////////////////////////////
  // query data
  $stock = new Stock_jewelry_order($data);
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
    width: 120px;
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
            <h1>สต็อกงานสั่งทำ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">สต็อกงานสั่งทำ</li>
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
                        <button class="btn btn-sm btn-primary" onclick="add_new()"><i class="fas fa-plus"></i> เพิ่มการสั่งทำ</button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-gold" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ชื่อลูกค้า</th>
                            <th>วันที่สั่งทำ</th>
                            <th>ประเภทสินค้า</th>
                            <th>ราคาประเมิน</th>
                            <th>มัดจำ</th>
                            <th>สถานะ</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php 
                            if($get_data != ""){
                              for($i=0;$i<count($get_data);$i++){
                                $stauts_product_id = $get_data[$i]['status'];
                                if($stauts_product_id == 1){
                                  $status_product = "สั่งทำ";
                                }
                                elseif($stauts_product_id == 2){
                                  $status_product = "รอลูกค้ารับ";
                                }
                                elseif($stauts_product_id == 3){
                                  $status_product = "ปิดการขาย";
                                }
  
                                echo "
                                  <tr>
                                    <td>".$get_data[$i]['customer_name']."</td>
                                    <td>".$get_data[$i]['order_date']."</td>
                                    <td>".$get_data[$i]['type_name']."</td>
                                    <td>".$get_data[$i]['estimate_price']."</td>
                                    <td>".$get_data[$i]['deposit']."</td>
                                    <td>".$status_product."</td>
                                    <td>
                                      <div class='row'>
                                        <div class='col-auto'><button type='button' class='btn btn-block bg-gradient-warning btn-cus-w' onclick='edit(".$get_data[$i]['id'].")'>ดู/แก้ไข</button></div>
                                      </div>
                                    </td>
                                  </tr>
                                ";
                              }
                            }
                          ?>
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
      location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-craft/add.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-jewelry/stock-craft/edit.php?id=${id}`
  }
</script>

</body>
</html>

