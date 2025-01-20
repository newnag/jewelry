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
  "amount" => "",
  "id" => $_GET['id']
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_equipment($data);
$query = $sql->get_data();
?>

<style>
    .btn-tb{
        margin-right: 5px;
    }
</style>

<input type="hidden" id="item_id" value="<?=$query['id']?>">

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>แก้ไขสินค้า</h1>
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
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="">ชื่ออุปกรณ์</label>
                    <input type="text" class="form-control" id="name" value="<?=$query['name']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Supplier</label>
                    <input type="text" class="form-control" id="supplier"  placeholder="" value="<?=$query['supplier']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">จำนวน</label>
                    <input type="number" class="form-control" id="amount" min="0" placeholder="" value="<?=$query['amount']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ราคา</label>
                    <input type="number" class="form-control" id="price" min="0" placeholder="" value="<?=$query['price']?>">
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-auto"><button class="btn btn-primary" onclick="update()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
                <div class="col-auto"><button class="btn btn-danger" onclick="item_delete(<?=$_GET['id']?>)">ลบ</button></div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<script src="js/stock.js"></script>

<script>
  get_type()
</script>

</body>
</html>

