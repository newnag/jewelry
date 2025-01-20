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


<style>
    .btn-tb{
        margin-right: 5px;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>เพิ่มสินค้า</h1>
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
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="">ชื่ออุปกรณ์</label>
                    <input type="text" class="form-control" id="name">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Supplier</label>
                    <input type="text" class="form-control" id="supplier"  placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">จำนวน</label>
                    <input type="number" class="form-control" id="amount" min="0" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ราคา</label>
                    <input type="number" class="form-control" id="price" min="0" placeholder="" value="">
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-auto"><button class="btn btn-primary" onclick="add()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<script src="js/stock.js"></script>

</body>
</html>

