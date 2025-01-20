<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-equipment.php') ;
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
  "name" => "",
  "price" => "",
  "supplier" => "",
  "amount" => "",
  "id" => ""
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_equipment($data);
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
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>สต็อกอุปกรณ์</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">สต็อกอุปกรณ์</li>
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
                            <th>ลำดับ</th>
                            <th>ชื่ออุปกรณ์</th>
                            <th>Suppler</th>
                            <th>จำนวน</th>
                            <th>ราคา</th>
                            <th>อัพเดทล่าสุด</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            if($query != ""){
                              for($i=0;$i<count($query);$i++){
                                $no = $i+1;
                                echo "
                                  <tr>
                                    <td>".$no."</td>
                                    <td>".$query[$i]['name']."</td>
                                    <td>".$query[$i]['supplier']."</td>
                                    <td>".$query[$i]['amount']."</td>
                                    <td>".$query[$i]['price']."</td>
                                    <td>".$query[$i]['update_date']."</td>
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
    location.href = "https://thavorn-jewelry.com/stock-jewelry/equipment/add.php"
  }

  function edit(id){
    location.href = `https://thavorn-jewelry.com/stock-jewelry/equipment/edit.php?id=${id}`
  }
</script>

</body>
</html>

