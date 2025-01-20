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

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">


<style>
    .btn-tb{
      margin-right: 5px;
    }

    .tb-action{
      width: 180px;
    }

    .main-sidebar{
      height: 1500px!important;
    }

    .highlight-table{
      background-color: #003366;
    }

    .head-table{
      background-color: #002244;
      color: #fff;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>รายงาน</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">รายงาน</li>
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
                    <div class="row">
                      <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                          <label>วันที่เริ่มต้น-สิ้นสุด:</label>

                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservation">
                          </div>
                          <!-- /.input group -->
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-2">
                        <button button type="button" class="btn btn-block btn-primary" style="width:100px" onclick="search()">ค้นหา</button>
                      </div>
                    </div>
                </div>
            </div>

            <div class="card">
              <div class="card-body">
                <div class="row" id="card">
                  
                </div>

                <div class="row">
                  <div class="col-sm-12">
                    <table id="table-report" class="table table-bordered table-hover">
                      <thead class="head-table">
                        <tr>
                          <th>รหัส</th>
                          <th>รูป</th>
                          <th>ชื่อสินค้า</th>
                          <th>ชื่อผู้ซื้อ</th>
                          <th>ราคาขาย</th>
                          <th>วันที่ซื้อขาย</th>
                          <th>สถานะ</th>
                        </tr>
                      </thead>

                      <tbody>
                        
                      </tbody>
                    </table>
                  </div>
                  
                </div>
              </div>
            </div>
        </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<script src="js/report.js"></script>

<script type="text/javascript">
  $('#reservation').daterangepicker()

</script>

</body>
</html>

