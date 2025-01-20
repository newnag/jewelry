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
              <li class="breadcrumb-item active">สต็อกเพชรร่วง</li>
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
                    <label for="">Supplier</label>
                    <input type="text" class="form-control" id="supplier">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">วันที่นำเข้า</label>
                    <input type="date" class="form-control" id="stock_date" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ราคาต้นทุน</label>
                    <input type="number" class="form-control" id="price" min="0" placeholder="" value="0">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">จำนวน</label>
                    <input type="number" class="form-control" id="amount" min="0" placeholder="" value="0">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ประเภทโลหะ</label>
                    <select name="" id="type_material" class="form-control">
                      <option value="M">โลหะ</option>
                      <option value="G">ทอง</option>
                      <option value="K">นาค</option>
                      <option value="S">เงิน</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">เปอร์เซ็นโลหะ</label>
                    <select name="" id="percent_gold" class="form-control">
                      <option value="90">90</option>
                      <option value="85">85</option>
                      <option value="80">80</option>
                      <option value="75">75</option>
                      <option value="18K">18K</option>
                      <option value="14K">14K</option>
                      <option value="12K">12K</option>
                      <option value="Silver">Silver</option>
                      <option value="other">อื่นๆ</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">เปอร์เซ็นอื่นๆ</label>
                    <input type="text" class="form-control" id="percent_gold_other"  value="" disabled>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">สีทอง</label>
                    <select name="" id="color" class="form-control">
                      <option value="WG">WG</option>
                      <option value="YG">YG</option>
                      <option value="PG">PG</option>
                      <option value="RG">RG</option>
                      <option value="PT">PT</option>
                      <option value="S">S</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนัก(กรัม)</label>
                    <input type="number" class="form-control" id="weight" min="0" placeholder="" value="0" >
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ค่าซิ</label>
                    <input type="number" class="form-control" id="si" min="0" placeholder="" value="0" >
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนักรวมซิ</label>
                    <input type="number" class="form-control" id="weight_total" min="0" placeholder="" value="0">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ประเภท</label>
                    <select class="form-control" id="product_type">

                    </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="">Note</label>
                    <textarea name="" id="note" class="form-control" cols="30" rows="4"></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">รูปภาพ</label>
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

<script>
  get_type()
</script>

</body>
</html>

