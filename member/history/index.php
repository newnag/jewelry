<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../functions/check-login.php');

check_login($conn);
?>

<div class="wrapper">
<?php 
    include('../../template/header.php');
    include('../template/aside.php');
?>


<style>
  .content-wrapper h1{
    color: #68a8a7;
  }
  .breadcrumb .breadcrumb-item a{
    color: #dc798c;
  }
  .breadcrumb .breadcrumb-item.active{
    color: #f7a686;
  }

  .btn-tb{
      margin-right: 5px;
  }

  .btn-search{
    background-color: #68a8a7;
    color: #fff;
  }

  input{
    border-color: #68a8a7!important;
  }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ประวัติการซื้อ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ประวัติการซื้อ</li>
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
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ชื่อลูกค้า / เบอร์โทรศัพท์ / เลขบัตรประจำตัว</label>
                    <input type="text" class="form-control" id="customer_id_input" placeholder="" value="">
                </div>
              </div>
              <div class="col-md-1" style="align-self: center;">
                <button class="btn btn-search" style="margin-top:15px;" onclick="search_customer_data()"><i class="fas fa-search"></i> ค้นหา</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<script src="js/history.js"></script>
</body>
</html>

