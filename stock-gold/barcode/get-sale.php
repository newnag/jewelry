<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/sale-gold.php');

check_login($conn);
?>

<div class="wrapper">
<?php 
  include('../../template/header.php');
  include('../template/aside.php');
?>

<?php
  $trans_id = $_GET['id'];
  $data = array(
    "conn" => $conn,
    "barcode" => "",
    "cus_id" => "",
    "item_id" => "",
    "sale_date" => "",
    "price_id" => "",
    "price" => "",
  );
 
  $sale = new Sale_gold($data);
  $get_data = $sale->get_data_sale($trans_id);
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
            <h1>รายการขาย</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">ระบบการขาย</a></li>
              <li class="breadcrumb-item active">ดูรายการขาย</li>
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
                  <div class="col-3"><h2>ผู้ซื้อสินค้า</h2></div>
                </div>

                <div class="keed"></div>

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
                            <input type="text" class="form-control read-gold " id="cus_name" readonly value="<?=$get_data['fullname']?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">เลขประจำตัว</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="id_no" readonly value="<?=$get_data['id_no']?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">เบอร์โทร</label>
                          <div class="col-7">
                            <input type="text" class="form-control read-gold " id="phone" readonly value="<?=$get_data['phone']?>">
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
                            <select name="" id="sex" class="form-control read-gold" disabled> 
                              <option value=""><?=$get_data['sex']?></option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">ได้รับคะแนน</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold" id="recive_point" readonly value="">
                          </div>
                        </div>
                      </div>

                      <?php
                        $dob = explode("-",$get_data['DOB']);
                        $dob_year = intval($dob[0])+543;
                        $dob = $dob[2]."/".$dob[1]."/".$dob_year;
                      ?>

                      <div class="col-auto">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">วันเกิด</label>
                          <div class="col-9">
                            <input type="text" class="form-control read-gold " id="dob" readonly value="<?=$dob?>">
                          </div>
                        </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">คะแนนรวม</label>
                          <div class="col-8">
                            <input type="text" class="form-control read-gold " id="point" readonly value="<?=$get_data['point']?>">
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
                        <input type="text" class="form-control read-gold " id="product_no" readonly value="<?=$get_data['product_no']?>">
                        <input type="hidden" id="item_id" value="">
                      </div>

                      <div class="col-3">
                        <label class="col-form-label">ประเภท</label>
                        <input type="text" class="form-control read-gold " id="type_product" readonly value="<?=$get_data['type_name']?>">
                      </div>

                      <div class="col-3">
                        <label class="col-form-label">หมวดหมู่</label>
                        <input type="text" class="form-control read-gold " id="cate_product" readonly value="<?=$get_data['cate_name']?>">
                      </div>

                      <div class="col-1">
                        <label class=" col-form-label">น้ำหนักทอง</label>
                        <input type="text" class="form-control read-gold " id="weight" readonly value="<?=$get_data['weight']?>">
                      </div>
                        
                      <div class="col-1">
                        <label class=" col-form-label">ขนาด</label>
                        <input type="text" class="form-control read-gold " id="size" readonly value="<?=$get_data['size']?>">
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-5">
                        <label class="col-form-label">รายละเอียดสินค้า</label>
                        <textarea name="" id="detail" class="form-control read-gold" cols="30" rows="6" readonly><?=$get_data['detail']?></textarea>
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">รหัสราคาทอง</label>
                        <input type="text" class="form-control read-gold " id="cost_id" readonly value="<?=$get_data['cost_id']?>">
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">รหัสค่าแรง</label>
                        <input type="text" class="form-control read-gold " id="wage_id" readonly value="<?=$get_data['cost_wage_id']?>">
                      </div>

                      <div class="col-2">
                        <label class="col-form-label">รหัสต้นทุน</label>
                        <input type="text" class="form-control read-gold " id="cost_price" readonly value="<?=$get_data['cost']?>">
                      </div>
                    </div>

                    <div class="row mt-4">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-5">
                            <label class="col-form-label">วันที่/เวลา ขาย</label>
                            <input type="text" class="form-control read-gold" id="date_sale" readonly value="<?=$get_data['sale_date']?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-4">
                            <label class="col-form-label">ราคาทองแท่ง</label>
                            <input type="text" class="form-control read-gold" id="gold_price" readonly value="<?=$get_data['gold_price']?>">
                            <input type="hidden" id="market_price" value="">
                          </div>

                          <div class="col-4">
                            <label class="col-form-label">ราคาสินค้ารวมภาษี</label>
                            <input type="text" class="form-control read-gold" id="net_vat" readonly value="<?=$get_data['net_total']?>">
                          </div>

                          <div class="col-4">
                            <label class="col-form-label">ฐานภาษี</label>
                            <input type="text" class="form-control read-gold" id="vat_base" readonly value="<?=$get_data['vat_base']?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-4">
                            <label class="col-form-label">ราคาค่าแรง</label>
                            <input type="text" class="form-control read-gold" id="wage" readonly value="<?=$get_data['wage']?>">
                          </div>

                          <div class="col-4">
                            <label class="col-form-label">ราคารับซื้อคืน (หัก)</label>
                            <input type="text" class="form-control read-gold" id="resale_price" readonly value="<?=$get_data['resale_price']?>">
                          </div>

                          <div class="col-4">
                            <label class="col-form-label">ภาษี</label>
                            <input type="text" class="form-control read-gold" id="vat" readonly value="<?=$get_data['vat']?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-4">
                            <label class="col-form-label">รวมราคาขาย</label>
                            <input type="text" class="form-control read-gold" id="sum_sale" readonly value="<?=$get_data['sum_price']?>">
                          </div>

                          <div class="col-4">
                            <label class="col-form-label">ผลต่างราคาขายรวมภาษี</label>
                            <input type="text" class="form-control read-gold" id="diff" readonly value="<?=$get_data['diff_sell_price']?>">
                          </div>

                          <div class="col-4">
                            <label class="col-form-label">มูลค่าสินค้าไม่รวมภาษี</label>
                            <input type="text" class="form-control read-gold" id="price_exclude" readonly value="<?=$get_data['vat_exclude']?>">
                          </div>
                        </div>
                      </div>

                      <div class="col-6">
                        <label class="col-form-label">รูปสินค้า</label>
                        <div class="thumbnail"><img src="https://thavorn-jewelry.com/uploads/stock-gold/<?=$get_data['pic_path']?>" alt=""></div>
                      </div>
                    </div>

                    <div class="row mt-5">
                      <div class="col-6">
                        <div class="row">
                          <div class="col-auto"><button class="btn btn-gold btn-close" onclick="goback()">ปิด</button></div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="row"><div class="col-auto"><button class="btn btn-gold" onclick="print_invoice()"><i class="fas fa-print"></i> พิมพ์</button></div></div>
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
<form action="https://thavorn-jewelry.com/stock-gold/barcode/invoice.php" id="invoice-form" method="POST" target="TheInvoice">
  <input type="hidden" id="cus_id_invoice" name="cus_id_invoice" value="">
  <input type="hidden" id="cus_name_invoice" name="cus_name_invoice" value="">
  <input type="hidden" id="cus_idcard_invoice" name="cus_idcard_invoice" value="">
  <input type="hidden" id="address_invoice" name="address_invoice" value="">
  <input type="hidden" id="date_invoice" name="date_invoice" value="">
  <input type="hidden" id="gold_price_invoice" name="gold_price_invoice" value="">
  <input type="hidden" id="item_name_invoice" name="item_name_invoice" value="">
  <input type="hidden" id="item_weight_invoice" name="item_weight_invoice" value="">
  <input type="hidden" id="net_vat_invoice" name="net_vat_invoice" value="">
  <input type="hidden" id="resale_invoice" name="resale_invoice" value="">
  <input type="hidden" id="diff_invoice" name="diff_invoice" value="">
  <input type="hidden" id="vat_base_invoice" name="vat_base_invoice" value="">
  <input type="hidden" id="vat_invoice" name="vat_invoice" value="">
  <input type="hidden" id="vat_exclude_invoice" name="vat_exclude_invoice" value="">
  <input type="hidden" id="gold_sale_price" name="gold_sale_price" value="">
</form>

</div>

<?php include('../../template/footer.php'); ?>
<script src="js/barcode.js"></script>

</body>
</html>

