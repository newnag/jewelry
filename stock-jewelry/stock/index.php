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
      width: 250px;
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
            <h1>สต็อกสินค้า</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">สต็อกสินค้า</li>
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
                        <button class="btn btn-sm btn-primary" onclick="add_new()"><i class="fas fa-plus"></i> เพิ่มสินค้า</button>
                        <!-- <button class="btn btn-sm btn-primary" onclick="add_new_import()"><i class="fas fa-plus"></i> เพิ่มสินค้านำเข้า</button> -->
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-gold" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>รหัสสินค้า</th>
                            <th>ประเภทผลิต</th>
                            <th>วันที่เข้า</th>
                            <th>ประเภทสินค้า</th>
                            <th>ไซส์</th>
                            <th>น้ำหนัก</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php 
                            if($get_data){
                              for($i=0;$i<count($get_data);$i++){
                                // if($get_data[$i]['import'] == "true"){
                                //   echo'
                                //   <tr>
                                //     <td class="">'.$get_data[$i]['product_id'].'</td>
                                //     <td class="">นำเข้า</td>
                                //     <td class="">'.$get_data[$i]['import_date'].'</td>
                                //     <td class="">'.$get_data[$i]['product_cate'].'</td>
                                //     <td class="">'.$get_data[$i]['product_size'].'</td>
                                //     <td class="">'.$get_data[$i]['product_weight'].' กรัม</td>
                                //     <td>
                                //         <div class="col-12">
                                //           <div class="row">
                                //             <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit('.$get_data[$i]['id'].')">ดู/แก้ไข</button></div>
                                //           </div>
                                //         </div>
                                //     </td>
                                //   </tr>
                                // ';
                                // }
                                // else{
                                //   echo'
                                //     <tr>
                                //       <td class="">'.$get_data[$i]['product_no'].'</td>
                                //       <td class="">'.$get_data[$i]['type_build'].'</td>
                                //       <td class="">'.$get_data[$i]['stock_date'].'</td>
                                //       <td class="">'.$get_data[$i]['type_product'].'</td>
                                //       <td class="">'.$get_data[$i]['size'].'</td>
                                //       <td class="">'.$get_data[$i]['weight'].' กรัม</td>
                                //       <td>
                                //           <div class="col-12">
                                //             <div class="row">
                                //               <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit('.$get_data[$i]['id'].')">ดู/แก้ไข</button></div>
                                //             </div>
                                //           </div>
                                //       </td>
                                //     </tr>
                                //   ';
                                // }

                                echo'
                                  <tr>
                                    <td class="">'.$get_data[$i]['product_no'].'</td>
                                    <td class="">'.$get_data[$i]['type_build'].'</td>
                                    <td class="">'.$get_data[$i]['stock_date'].'</td>
                                    <td class="">'.$get_data[$i]['type_product'].'</td>
                                    <td class="">'.$get_data[$i]['size'].'</td>
                                    <td class="">'.$get_data[$i]['weight'].' กรัม</td>
                                    <td>
                                        <div class="col-12">
                                          <div class="row">
                                            <div class="col-auto"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit('.$get_data[$i]['id'].')">ดู/แก้ไข</button></div>
                                          </div>
                                        </div>
                                    </td>
                                  </tr>
                                ';
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
    location.href = "https://thavorn-jewelry.com/stock-jewelry/stock/add.php"
  }
  function add_new_import(){
    location.href = "https://thavorn-jewelry.com/stock-jewelry/stock/add-import.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-jewelry/stock/edit.php?id=${id}`
  }
</script>

</body>
</html>

