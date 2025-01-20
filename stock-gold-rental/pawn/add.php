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

    .content-wrapper{
      height: fit-content;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>เพิ่มรายการ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">การจำนำ</li>
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
              <div class="col-3"><h2>ชื่อลูกค้า</h2></div>

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
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ชื่อสินค้า</label>
                    <input type="text" class="form-control" id="product_name"  placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ราคาต้น</label>
                    <input type="text" class="form-control" id="price_rental" min="0" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ดอกต่อเดือน</label>
                    <input type="text" class="form-control" id="interest" min="0" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">มูลค่าสินค้า</label>
                    <input type="text" class="form-control" id="value" min="0" placeholder="" value="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">รูปสินค้า</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file_1" onchange="change_name_pic(this)">
                        <label class="custom-file-label" for="file_1">Choose file</label>
                      </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control" id="detail" rows="4" placeholder=""></textarea>
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

