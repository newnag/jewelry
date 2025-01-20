<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-jewelry-body.php') ;
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
  "supplier" => "",
  "stock_date" => "",
  "price" => "",
  "weight" => "",
  "amount" => "",
  "type" => "",
  "id" => ""
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_jewelry_body($data);
$query = $sql->get();
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
      width: 130px;
    }

    .main-sidebar{
      min-height: 1100px!important;
    }

    .thumbnail{
      width: 120px;
      height: 120px;
    }
    .thumbnail img{
      width:100%;
      height:100%;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>สต็อกตัวเรือน</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">สต็อกตัวเรือน</li>
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
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-gold" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="80">ลำดับ</th>
                            <th>รูป</th>
                            <th>Supplier</th>
                            <th>วันที่เข้า</th>
                            <th>ราคา</th>
                            <th>น้ำหนัก</th>
                            <th>จำนวน</th>
                            <th>ประเภท</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            if($query != "" || $query != null){
                              for($i=0;$i<count($query);$i++){
                                $no = $i+1;

                                $get_pic = $sql->get_pic($query[$i]['id']);

                                echo "
                                  <tr>
                                    <td>".$no."</td>
                                    <td class='thumbnail'><img src='https://thavorn-jewelry.com/uploads/stock-body/".$get_pic['path']."'></td>
                                    <td>".$query[$i]['supplier']."</td>
                                    <td>".$query[$i]['stock_date']."</td>
                                    <td>".$query[$i]['price']."</td>
                                    <td>".$query[$i]['weight']."</td>
                                    <td>".$query[$i]['amount']."</td>
                                    <td>".$query[$i]['type_name']."</td>
                                    <td>
                                      <div class='row'>
                                        <div class='col-auto'><button type='button' class='btn btn-block bg-gradient-warning btn-cus-w' onclick='edit(".$query[$i]['id'].")'>ดู/แก้ไข</button></div>
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
    location.href = "https://thavorn-jewelry.com/stock-jewelry/stock-body/add.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-jewelry/stock-body/edit.php?id=${id}`
  }
</script>

</body>
</html>

