<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/buying-gold.php') ;

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
    "po_no" => "",
    "cus_id" => "",
    "datetime" => "",
    "type_product" => "",
    "amount" => "",
    "weight" => "",
    "detail" => "",
    "price_buy" => "",
    "price_sell" => "",
    "price_buy_num" => "",
    "price_buy_txt" => "",
    "customFile" => "",
    "id" => $_GET['id']
  );

  $buy_pre = new Buy_gold($data);
  $query = $buy_pre->get_data_sale();
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
    max-width: 100%;
    max-height: 350px;
  }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>บันทึกรายการรับซื้อ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">ระบบการรับซื้อ</a></li>
              <li class="breadcrumb-item active">เพิ่มรายการรับซื้อ</li>
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
                  <div class="col-3"><h2>ผู้ขายสินค้า</h2></div>
                </div>

                <div class="keed"></div>

                <div class="row mt-3"> 
                  <div class="col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row">
                          <label class="col-sm-1 col-form-label">รหัสลูกค้า: </label>
                          <div class="col-9" style="display:flex;align-items: center;">
                            <p class="" style="margin:0;" id="customer_id"><?=$query['id_customer']?></p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">ชื่อ-สกุล</label>
                          <div class="col-9">
                            <input type="text" class="form-control read-gold " id="cus_name" readonly value="<?=$query['fullname']?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">เลขประจำตัว</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="id_no" readonly value="<?=$query['id_no']?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">เบอร์โทร</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="phone" readonly value="<?=$query['phone']?>">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-5">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">ที่อยู่</label>
                          <div class="col-10">
                            <textarea name="" id="address" class="form-control read-gold" cols="30" rows="6" readonly><?=$query['address']?></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-auto">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">เพศ</label>
                          <div class="col-6">
                            <select name="" id="sex" class="form-control read-gold" disabled> 
                              <option value=""><?=$query['sex']?></option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">ได้รับคะแนน</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold" id="recive_point" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-auto">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">วันเกิด</label>
                          <div class="col-9">
                            <input type="text" class="form-control read-gold " id="dob" readonly value="<?=$query['DOB']?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">คะแนนรวม</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold " id="point" readonly value="<?=$query['point']?>">
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
                <div class="row justify-content-between">
                  <div class="col-3">
                    <h2>รายการซื้อ</h2>
                  </div>

                  <div class="col-6">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">รหัสรับซื้อ : </label>
                      <div class="col-6"><input type="text" class="form-control read-gold" readonly value="<?=$query['po_no']?>"></div>
                      <input type="hidden" id="po_no" value="<?=$query['po_no']?>">
                    </div>
                  </div>
                </div>

                <div class="keed"></div>

                <div class="row mt-3"> 
                  <div class="col-12">
                    <div class="row">
                      <div class="col-3">
                        <label class="col-form-label">วันที่/เวลารับซื้อ</label>
                        <input type="datetime-local" class="form-control " id="datetime" value="<?=$query['date']?>" readonly>
                      </div>

                      <div class="col-5">
                        <label class="col-form-label">ประเภท</label>
                        <select class="form-control" disabled>
                          <option value=""><?=$query['type_name']?></option>
                        </select>
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">จำนวน</label>
                        <input type="text" class="form-control " id="amount" value="<?=$query['amount']?>" readonly>
                      </div>

                      <div class="col-2">
                        <label class=" col-form-label">น้ำหนัก</label>
                        <input type="text" class="form-control " id="weight" value="<?=$query['weight']?>" readonly>
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-12">
                            <label class="col-form-label">รูปสินค้า</label>
                            <div class="thumbnail"><img src="https://thavorn-jewelry.com/uploads/buy-gold/<?=$query['pic_path']?>" alt=""></div>
                          </div>
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="row">
                          <div class="col-6">
                            <label class="col-form-label">ราคารับซื้อทองแท่ง</label>
                            <input type="number" class="form-control " id="price_buy" value="<?=$query['price_buy']?>" readonly>
                          </div>
                          <div class="col-6">
                            <label class="col-form-label">ราคาขายทองแท่ง</label>
                            <input type="number" class="form-control " id="price_sell" value="<?=$query['price_sell']?>" readonly>
                          </div>

                          <div class="col-12">
                            <label class="col-form-label">รายละเอียดสินค้า</label>
                            <textarea name="" id="detail" class="form-control" cols="30" rows="14" readonly><?=$query['detail']?></textarea>
                          </div>
                        </div> 
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label class="col-form-label">ราคารับซื้อ(ตัวเลข)</label>
                            <input type="number" class="form-control" id="price_buy_num" placeholder="ตัวเลข" value="<?=$query['price_buy_num']?>" readonly>
                          </div>
                          <div class="col-8">
                            <label class="col-form-label">ราคารับซื้อ(ตัวอักษร)</label>
                            <input type="text" class="form-control" id="price_buy_txt" placeholder="ตัวอักษร" value="<?=$query['price_buy_txt']?>" readonly>
                          </div>
                        </div>
                      </div>

                      
                    </div>

                    <div class="row mt-5">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-auto"><button class="btn btn-gold btn-close" onclick="goback()">ปิด</button></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="row"><div class="col-auto"><button class="btn btn-gold" onclick="print_PO()"><i class="fas fa-print"></i> พิมพ์</button></div></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
    </section>
</div>

<!-- data to invoice -->
<form action="https://thavorn-jewelry.com/stock-gold/buying/po.php" id="po-form" method="POST" target="Po">
  <input type="hidden" id="po_no_form" name="po_no_form" value="">
  <input type="hidden" id="datetime_form" name="datetime_form" value="">
  <input type="hidden" id="cus_name_form" name="cus_name_form" value="">
  <input type="hidden" id="id_no_form" name="id_no_form" value="">
  <input type="hidden" id="address_form" name="address_form" value="">
  <input type="hidden" id="phone_form" name="phone_form" value="">
  <input type="hidden" id="detail_form" name="detail_form" value="">
  <input type="hidden" id="price_buy_form" name="price_buy_form" value="">
  <input type="hidden" id="price_sell_form" name="price_sell_form" value="">
  <input type="hidden" id="price_buy_num_form" name="price_buy_num_form" value="">
  <input type="hidden" id="price_buy_txt_form" name="price_buy_txt_form" value="">
  <input type="hidden" id="picture_form" name="picture_form" value="">
</form>

</div>

<?php include('../../template/footer.php'); ?>
<script src="js/buy.js"></script>
<script>
  get_type()
</script>
</body>
</html>

