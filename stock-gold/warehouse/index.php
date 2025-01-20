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

  $stock = new Stock_gold($data);
  $get_stock = $stock->get_warehouse();

  $data_type = array(
    "conn" => $conn,
    "type_name" => "",
    "cate_name" => "",
    "type_id" => "",
    "id" => ""
  );
  $type = new Type_product($data_type);
  $get_type = $type->get_type_stock("1");
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลคลัง</h1>
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
                  <div class="card-title">
                    <div class="search-section">
                      <div class="search">
                        <label for="">Search:</label>
                        <input type="text" class="form-control" id="search_name" placeholder="ค้นหาสินค้าโดยรหัส/ชื่อสินค้า">
                      </div>
  
                      <div class="search search-type">
                        <select class="form-control" id="search_type">
                          <option value="">เลือกประเภทสินค้า</option>
                          <?php
                            foreach($get_type as $type){
                              echo '
                                <option value="'.$type['id'].'">'.$type['type_name'].'</option>
                              ';
                            }
                          ?>
                        </select>
                      </div>
  
                      <div class="search search-cate">
                        <select class="form-control" id="search_cate">
                          <option value="">เลือกหมวดหมู่สินค้า</option>
                        </select>
                      </div>

                      <div class="btn-search"><button class="btn" onclick="search()"><i class="fas fa-search"></i>ค้นหา</button></div>
                    </div>
                  </div>

                  <div class="card-tools">
                    <button class="btn btn-add" onclick="barcode_page()"><i class="fas fa-barcode"></i> พิมพ์บาร์โค้ด</button>
                    <?php
                      if($_SESSION['role'] == 1){
                        echo '<button class="btn btn-add" onclick="add_new()"><i class="fas fa-plus"></i> เพิ่มสินค้า</button>';
                      }
                    ?>
                  </div>
                </div>

                <div class="card-body">
                    <table id="table-gold" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>รหัสสินค้า</th>
                            <th>ประเภท</th>
                            <th>หมวดหมู่</th>
                            <th>น้ำหนัก/กรัม</th>
                            <th>ราคาทอง</th>
                            <th>ค่าแรง</th>
                            <th>รูปภาพ</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            if($get_stock != ""){
                              for($i=0;$i<count($get_stock);$i++){
                                echo '
                                <tr>
                                  <td class="">'.$get_stock[$i]["product_no"].'</td>
                                  <td class="">'.$get_stock[$i]["type_name"].'</td>
                                  <td class="">'.$get_stock[$i]["cate_name"].'</td>
                                  <td class="">'.$get_stock[$i]["weight"].'</td>
                                  <td class="cost-id">'.$get_stock[$i]["cost_id"].'</td>
                                  <td class="">'.$get_stock[$i]["wage"].'</td>
                                  <td class="thumbnail"><img src="https://thavorn-jewelry.com/uploads/stock-gold/'.$get_stock[$i]["pic_path"].'"></td>
                                  <td>
                                    <button type="button" class="btn btn-block btn-cus-w btn-action" onclick="edit('.$get_stock[$i]["id"].')">ดู/แก้ไข</button>
                                  </td>
                                </tr>
                                ';
                              }
                            }
                            else{
                              
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
        "ordering": true,
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

