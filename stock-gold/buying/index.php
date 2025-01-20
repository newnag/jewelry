<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');

check_login($conn);
?>

<div class="wrapper">
<?php 
  include('../../template/header.php');
  include('../template/aside.php');
?>

<?php

// include "../../plugins/barcode-gen/BarcodeGenerator.php";
// include "../../plugins/barcode-gen/BarcodeGeneratorHTML.php";
 
// $code = "000001";//รหัส Barcode ที่ต้องการสร้าง
 
// $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
// $border = 2;//กำหนดความหน้าของเส้น Barcode
// $height = 50;//กำหนดความสูงของ Barcode
 
// echo $generator->getBarcode($code , $generator::TYPE_CODE_128,$border,$height);
// echo $code ;
 
// echo "<hr>";
 
?>


<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">

<style>
  .content-wrapper{
    height: fit-content;
  }

  .btn-tb{
    margin-right: 5px;
  }

  .btn-gold{
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
    flex-direction: column;
    margin-right: 1em;
  }
  .search label{
    margin: 0;
    margin-right: 5px;
    color: #07504b;
  }
  .search input,
  .search select{
    border-color: #d9a82a;
  }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลการรับซื้อ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ระบบการรับซื้อ</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-12"><button class="btn btn-gold" onclick="add()"><i class="fas fa-plus"></i> เพิ่มรายการรับซื้อ</button></div>
                  </div>

                  <div class="row mt-3">
                    <div class="col-12">
                      <div class="row">
                        <div class="col-6">
                          <div class="search">
                            <label for="">ค้นหาข้อมูลการขาย</label>
                            <input type="text" class="form-control" id="search_name" placeholder="ค้นหาชื่อลูกค้า/รหัสสินค้า">
                          </div>
                        </div>

                        <div class="col-3">
                          <div class="search">
                            <label for="">ช่วงเวลา</label>
                            <!-- <input type="text" class="form-control" id="range_date"> -->
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text" style="background-color:#d9a82a;border-color:#d9a82a">
                                  <i class="far fa-calendar-alt" style="color:#951b1e"></i>
                                </span>
                              </div>
                              <input type="text" class="form-control float-right" id="range_date">
                            </div>
                          </div>
                        </div>

                        <div class="col-2 align-self-end"><button class="btn btn-gold" onclick="search_sale_his()"><i class="fas fa-search"></i> ค้นหา</button></div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="card">
              <div class="card-body">
                <table id="table-report" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>วันที่/เวลา</th>
                      <th>ชื่อลูกค้า/ผู้ขาย</th>
                      <th>รหัสใบรับซื้อ</th>
                      <th>ประเภทสินค้า</th>
                      <th>จำนวนเงิน</th>
                      <th width="100">Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<script src="js/buy.js"></script>
<script type="text/javascript">
  $('#range_date').daterangepicker()

  $(document).ready( function () {
    setTimeout(() => {
      $('#table-report').DataTable({
        "paging": true,
        "lengthChange": true,
        "ordering": false,
        "info": true,
        "searching":false,
        "autoWidth": false,
        "responsive": true,
      });
    }, 300);  
  });
</script>

</body>
</html>

