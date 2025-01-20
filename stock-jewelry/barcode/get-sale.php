<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/sale-jewelry.php') ;

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

<?php
  $data = array(
    "conn" => $conn,
    "barcode" => "",
    "cus_id" => "",
    "item_id" => "",
    "sale_date" => "",
    "sale_price" => "",
    "sell_price" => "",
    "point_received" => "",
  );

  $pre_data = new Sale_jewelry($data);
  $get_data = $pre_data->get_data_sale($_GET['id']);

  // print_r($get_data);
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
  .btn-red{
    background-color: #fff;
    border-color: #d9a82a;
    color: #951b1e;
  }
  .btn-close{
    background-color: #d9a82a8a;
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

  .read-gold{
    background-color: #ffd882!important;
  }

  .thumbnail img{
    width: 100%;
    height: auto;
    max-width: 420px;
    max-height: 270px;
  }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>บันทึกรายการขาย</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">ระบบการขาย</a></li>
              <li class="breadcrumb-item active">รายการขาย</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="card">
              <div class="card-body">
                <div class="row mt-3"> 
                  <div class="col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row">
                          <label class="col-sm-1 col-form-label">รหัสลูกค้า: </label>
                          <div class="col-9" style="display:flex;align-items: center;">
                            <p class="" style="margin:0;" id="customer_id"><?=$get_data['id_customer']?></p>
                          </div>
                        </div>
                        
                        <input type="hidden" id="cus_sale_id">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">ชื่อ-สกุล</label>
                          <div class="col-9">
                            <input type="text" class="form-control read-gold " id="cus_name" value="<?=$get_data['fullname']?>" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">เลขประจำตัว</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="id_no" value="<?=$get_data['id_no']?>" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">เบอร์โทร</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="phone" value="<?=$get_data['phone']?>" readonly>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-5">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">ที่อยู่</label>
                          <div class="col-10">
                            <textarea name="" id="address" class="form-control read-gold" cols="30" rows="6" readonly><?=$get_data['address']?></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-auto">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">เพศ</label>
                          <div class="col-6">
                            <input type="text" class="form-control read-gold" id="sex" value="<?=$get_data['sex']?>" readonly>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">ได้รับคะแนน</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold" id="recive_point" value="<?=$get_data['']?>" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-auto">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">วันเกิด</label>
                          <div class="col-9">
                            <input type="text" class="form-control read-gold " id="dob" value="<?=$get_data['DOB']?>" readonly>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">คะแนนรวม</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold " id="point" value="<?=$get_data['point']?>" readonly>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>

          <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-3"><h2>รายการขาย</h2></div>
                </div>

                <div class="keed"></div>

                <div class="row mt-3"> 
                  <div class="col-12">
                    <div class="row">
                      <div class="col-4">
                        <label class="col-form-label">รหัสสินค้า</label>
                        <input type="text" class="form-control " id="product_no" value="<?=$get_data['product_no']?>" readonly>
                        <input type="hidden" id="item_id" value="">
                      </div>

                      <div class="col-4">
                        <label class="col-form-label">ชื่อสินค้า</label>
                        <input type="text" class="form-control " id="product_name" value="<?=$get_data['product_name']?>" readonly>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-3">
                        <label class="col-form-label">ประเภท</label>
                        <input type="text" class="form-control " id="type_product" value="<?=$get_data['type_name']?>" readonly>
                      </div>

                      <div class="col-3">
                        <label class="col-form-label">หมวดหมู่</label>
                        <input type="text" class="form-control " id="cate_product" value="<?=$get_data['cate_name']?>" readonly>
                      </div>

                      <div class="col-1">
                        <label class=" col-form-label">น้ำหนักทอง</label>
                        <input type="text" class="form-control " id="weight" value="<?=$get_data['weight']?>" readonly>
                      </div>
                        
                      <div class="col-1">
                        <label class=" col-form-label">ขนาด</label>
                        <input type="text" class="form-control " id="size" value="<?=$get_data['size']?>" readonly>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-5">
                        <label class="col-form-label">รายละเอียดสินค้า</label>
                        <textarea name="" id="detail" class="form-control" cols="30" rows="6" readonly><?=$get_data['detail']?></textarea>
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">รหัสต้นทุน</label>
                        <input type="text" class="form-control " id="cost_id" value="<?=$get_data['cost_id']?>" readonly>
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">ราคาต้นทุน</label>
                        <input type="text" class="form-control " id="cost_price" value="<?=$get_data['cost']?>" readonly>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-5">
                            <label class="col-form-label">วันที่/เวลา ขาย</label>
                            <input type="text" class="form-control " id="" value="<?=$get_data['sale_date']?>" readonly>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-6">
                            <label class="col-form-label">ราคาขาย</label>
                            <input type="number" class="form-control" id="sale_price" value="<?=$get_data['sale_price']?>" readonly>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-6">
                            <label class="col-form-label">ราคารับซื้อคืน</label>
                            <input type="number" class="form-control" id="sell_price" value="<?=$get_data['sell_price']?>" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-6">
                        <label class="col-form-label">รูปสินค้า</label>
                        <div class="thumbnail"><img src="https://thavorn-jewelry.com/uploads/stock-jewelry/<?=$get_data['path_1']?>" alt=""></div>
                      </div>
                    </div>

                    <div class="row mt-5">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-auto"><button class="btn btn-gold btn-close" onclick="goback()">ปิด</button></div>
                          <?php
                            $date_sale = date_create($get_data['sale_date']);
                            $date_now = date_create(date('Y-m-d H:i:s'));
                            $date_diff = date_diff($date_sale,$date_now);

                            if($date_diff->days <= 30){
                              echo '<div class="col-auto"><button class="btn btn-danger" onclick="disable_sale('.$_GET['id'].','.$get_data['product_id'].')">ยกเลิกการขาย</button></div>';
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>
<script src="js/barcode.js"></script>
<script>
  function print_warranty(){
    const item_id = document.querySelector('#item_id').value
    const cus_sale_id = document.querySelector('#cus_sale_id').value
    const price = document.querySelector('#sale_price').value
    const link = "https://thavorn-jewelry.com/stock-jewelry/barcode/warranty.php?id="+item_id+"&user_id="+cus_sale_id+"&price="+price

    window.open(link,'_blank')
    
  }
</script>

</body>
</html>

