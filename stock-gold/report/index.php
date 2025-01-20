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

    .content-wrapper{
      height: fit-content;
    }

    .highlight-table{
      background-color: #951b1e;
    }

    #block-month{
      display: none;
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
                          <label>ประเภทรายงาน</label>
                          <select class="custom-select" id="type_report">
                            <option value="1">รายงานขาย</option>
                            <option value="2">รายงานยอดคงคลัง</option>
                            <option value="3">รายงานยอดสต็อก</option>
                            <option value="4">รายงานประจำเดือน</option>
                            <option value="5">รายงานภาษีซื้อ</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-lg-6 col-sm-12" id="block-date">
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

                      <div class="col-lg-6 col-sm-12" id="block-month">
                        <div class="form-group">
                          <label>เลือกเดือน:</label>

                          <div class="input-group">
                            <select name="" id="select_month" class="form-control">
                              <option value="1">มกราคม</option>
                              <option value="2">กุมภาพันธ์</option>
                              <option value="3">มีนาคม</option>
                              <option value="4">เมษายน</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-2">
                        <button button type="button" id="search_btn" class="btn btn-block btn-primary" style="width:100px" onclick="search()">ค้นหา</button>
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
                     
                    </table>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </section>
</div>


<form action="https://thavorn-jewelry.com/stock-gold/report/report-sale.php" id="report-form" method="POST" target="TheInvoice">
  <input type="hidden" id="report_item_id" name="report_item_id" value="">
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

