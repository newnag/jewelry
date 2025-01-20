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

// zone api gold price
header('Access-Control-Allow-Origin: *');
$data_url = "http://www.thaigold.info/RealTimeDataV2/gtdata_.txt";
$data_json = file_get_contents($data_url); 
$data_array = json_decode($data_json);
 
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

                  <div class="col-5">
                    <input type="text" class="form-control" id="search_name" placeholder="ชื่อ/เบอร์โทร/เลขบัตรประชาชน">
                  </div>

                  <div class="col-auto"><button class="btn btn-gold" onclick="search_customer_data()"><i class="fas fa-search"></i> ค้นหา</button></div>
                  <div class="col-auto"><button class="btn btn-red" onclick="add_user()"><i class="fas fa-user-plus"></i> เพิ่มสมาชิก</button></div>
                </div>

                <div class="keed"></div>

                <div class="row mt-3"> 
                  <div class="col-12">
                    <div class="row">
                      <div class="col-12">
                        <div class="form-group row">
                          <label class="col-sm-1 col-form-label">รหัสลูกค้า: </label>
                          <div class="col-9" style="display:flex;align-items: center;">
                            <p class="" style="margin:0;" id="customer_id"></p>
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
                            <input type="text" class="form-control read-gold " id="cus_name" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">เลขประจำตัว</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="id_no" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">เบอร์โทร</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="phone" readonly>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-5">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">ที่อยู่</label>
                          <div class="col-10">
                            <textarea name="" id="address" class="form-control read-gold" cols="30" rows="6" readonly></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-auto">
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">เพศ</label>
                          <div class="col-6">
                            <select name="" id="sex" class="form-control read-gold" disabled> 

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
                            <input type="text" class="form-control read-gold " id="dob" readonly>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">คะแนนรวม</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold " id="point" readonly>
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
                      <div class="col-6"><input type="text" class="form-control read-gold" readonly></div>
                      <input type="hidden" id="po_no" value="000001">
                    </div>
                  </div>
                </div>

                <div class="keed"></div>

                <div class="row mt-3"> 
                  <div class="col-12">
                    <div class="row">
                      <div class="col-3">
                        <label class="col-form-label">วันที่/เวลารับซื้อ</label>
                        <input type="datetime-local" class="form-control " id="datetime" >
                      </div>

                      <div class="col-5">
                        <label class="col-form-label">ประเภท</label>
                        <select class="form-control" id="type_product">

                        </select>
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">จำนวน</label>
                        <input type="text" class="form-control " id="amount" >
                      </div>

                      <div class="col-2">
                        <label class=" col-form-label">น้ำหนัก</label>
                        <input type="text" class="form-control " id="weight" >
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-12">
                            <label class="col-form-label">รูปสินค้า</label>
                            <div class="thumbnail"><img src="../../asset/img/default.jpg" alt=""></div>
                          </div>

                          <div class="col-12 mt-3">
                            <div class="form-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" accept="image/*" onchange="change_pic(event)">
                                <label class="custom-file-label" for="customFile">เลือกรูปภาพ</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="row">
                          <div class="col-6">
                            <label class="col-form-label">ราคารับซื้อทองแท่ง</label>
                            <input type="text" class="form-control " id="price_buy" value="<?=$data_array[4]->ask?>">
                          </div>
                          <div class="col-6">
                            <label class="col-form-label">ราคาขายทองแท่ง</label>
                            <input type="text" class="form-control " id="price_sell" value="<?=$data_array[4]->bid?>">
                          </div>

                          <div class="col-12">
                            <label class="col-form-label">รายละเอียดสินค้า</label>
                            <textarea name="" id="detail" class="form-control" cols="30" rows="12" ></textarea>
                          </div>
                        </div> 
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-4">
                            <label class="col-form-label">ราคารับซื้อ(ตัวเลข)</label>
                            <input type="number" class="form-control" id="price_buy_num" placeholder="ตัวเลข">
                          </div>
                          <div class="col-8">
                            <label class="col-form-label">ราคารับซื้อ(ตัวอักษร)</label>
                            <input type="text" class="form-control" id="price_buy_txt" placeholder="ตัวอักษร">
                          </div>
                        </div>
                      </div>

                      
                    </div>

                    <div class="row mt-5">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-auto"><button class="btn btn-gold" onclick="buying()">บันทึก</button></div>
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
  // get_gold_price()
</script>
</body>
</html>

