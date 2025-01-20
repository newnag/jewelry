<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/stock-gold.php');

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
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">


<style>
    .btn-tb{
      margin-right: 5px;
    }

    .tb-action{
      width: fit-content;
    }
    table,
    table thead tr th,
    table tbody tr td{
      border-color: #d9a82a!important;
    }

    .content-wrapper{
      height: fit-content;
    }

    tbody .child .dtr-details{
      min-width: 200px;
    }

    .thumbnail img{
      width: 100px;
      height: 100px;
    }

    .btn-action{
      background-color: #d9a82a;
      color: #951b1e;
    }
    .btn-add{
      background-color: #d9a82a;
      color: #951b1e;
    }
    .btn-search button{
      background-color: #d9a82a;
      color: #951b1e;
    }

    .search-section{
      display: flex;
      justify-content: space-around;
      width: 100%;
    }
    .search{
      display: flex;
      align-items: center;
      margin-right: 1em;
    }
    .search label{
      margin: 0;
      margin-right: 5px;
    }
    .search input,
    .search select{
      border-color: #d9a82a;
    }
</style>

<?php
  $type_id = $_GET['type'];

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
    "wage_id" => "",
    "wage" => "",
    "sale_date" => "",
    "price_id" => "",
    "price" => "",
    "status" => "",
    "id" => ""
  );

  $dataType = array(
    "conn" => $conn,
    "type_name" => "",
    "cate_name" => "",
    "type_id" => $type_id,
    "id" => $type_id
  );

  $types = new Type_product($dataType);
  $getcate = $types->get_cate_stock();
  $gettype = $types->get_type_id();

  $stock = new Stock_gold($data);

  $get_his_add = array();
  $get_his_remove = array();
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูล <?=$gettype['type_name']?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">คลังสินค้า</a></li>
              <li class="breadcrumb-item active">ข้อมูลคลัง</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                </div>

                <div class="card-body">
                    <table id="table-gold" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>สถานะ</th>
                            <th>เพิ่ม</th>
                            <th>วันที่</th>
                            <th>ลด</th>
                            <th>วันที่</th>
                            <th>คงเหลือ</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            for($i=0;$i<count($getcate);$i++){
                              $get_his_add[$i] = $stock->call_history($getcate[$i]['id'],2,1);
                              $get_his_remove[$i] = $stock->call_history($getcate[$i]['id'],2,2);

                              if($get_his_add[$i] == ""){
                                $get_his_add[$i]['amount'] = "0";
                                $get_his_add[$i]['date'] = "0000-00-00";
                              }
                              if($get_his_remove[$i] == ""){
                                $get_his_remove[$i]['amount'] = "0";
                                $get_his_remove[$i]['date'] = "0000-00-00";
                              }

                              $amount_cate = $stock->amount_table($getcate[$i]['id'],1);
                              if($amount_cate == ""){
                                $amount_cate = "0";
                              }

                              echo '
                                <tr>
                                  <th>'.$getcate[$i]['cate_name'].'</th>
                                  <th>'.$get_his_add[$i]['amount'].'</th>
                                  <th>'.$get_his_add[$i]['date'].'</th>
                                  <th>'.$get_his_remove[$i]['amount'].'</th>
                                  <th>'.$get_his_remove[$i]['date'].'</th>
                                  <th>'.$amount_cate['amount'].'</th>
                                </tr>
                              ';
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
    // get()

    setTimeout(() => {
      $('#table-gold').DataTable({
        "paging": true,
        "lengthChange": true,
        "ordering": false,
        "info": true,
        "searching":false,
        "autoWidth": false,
        "responsive": true,
      });
    }, 500);
    
  });

  function add_new(){
      location.href = "https://thavorn-jewelry.com/stock-gold/warehouse/add.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-gold/warehouse/edit.php?id=${id}`
  }

  // เมื่อเลือกประเภทสินค้า
  document.querySelector('#search_type').addEventListener('change',()=>{
    let data = {id:document.querySelector('#search_type').value}
    $("#search_cate").empty()

    $.ajax({
      method: "POST",
      url: "functions/get-cate.php",
      data: data,
      dataType: 'json',
      success:function(result){
        // console.log(result)
        if(result != "error"){
          const select_type = document.querySelector('#search_cate')

          for(i=0;i<result.length;i++){
              
              let tem = `
              <option value="${result[i].id}">${result[i].cate_name}</option>
              `
              select_type.insertAdjacentHTML('beforeend',tem)
          }
        } 
      },
      error:function(textStatus){
        console.log(textStatus.responseText)
        const select_type = document.querySelector('#search_cate')
        let tem = `
        <option value="">เลือกหมวดหมู่สินค้า</option>
        `
        select_type.insertAdjacentHTML('beforeend',tem)
      }
    })
  })
</script>

</body>
</html>

