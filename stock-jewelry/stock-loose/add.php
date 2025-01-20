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

    .main-sidebar{
      height: 850px!important;
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

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">Supplier Lot</label>
                    <input type="text" class="form-control" id="supplier_lot">
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
                    <input type="number" class="form-control" id="price" min="0" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนัก(กะรัต)</label>
                    <input type="number" class="form-control" id="weight" min="0" placeholder="" value="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนักรวม(ห่อ)</label>
                    <input type="number" class="form-control" id="weight_total" min="0" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ไซส์ (mm)</label>
                    <input type="text" class="form-control" id="size" min="0" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">จำนวน</label>
                    <input type="number" class="form-control" id="amount" min="0" placeholder="" value="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">สี</label>
                    <select name="color" id="color" class="form-control">
                      <option value="N/A">N/A</option>    
                      <option value="D (100)">D (100)</option>
                      <option value="E (99)">E (99)</option>
                      <option value="F (98)">F (98)</option>
                      <option value="G (97)">G (97)</option>
                      <option value="H (96)">H (96)</option>
                      <option value="I (95)">I (95)</option>
                      <option value="J (94)">J (94)</option>
                      <option value="K (93)">K (93)</option>
                      <option value="L (92)">L (92)</option>
                      <option value="M-Z">M-Z</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ความบริสุทธิ์</label>
                    <select name="clarity" id="clarity" class="form-control">
                      <option value="N/A">N/A</option>  
                      <option value="FL/IF">FL/IF</option>
                      <option value="VVS1">VVS1</option>
                      <option value="VVS2">VVS2</option>
                      <option value="VS1">VS1</option>
                      <option value="VS2">VS2</option>
                      <option value="SI1">SI1</option>
                      <option value="SI2">SI2</option>
                      <option value="I1">I1</option>
                      <option value="I2">I2</option>
                      <option value="I3">I3</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">อื่นๆ</label>
                    <input type="text" class="form-control" name="other" id="other" >
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Cut สัดส่วน</label>
                    <select name="proportion_cut" id="proportion_cut" class="form-control">
                      <option value="N/A">N/A</option>  
                      <option value="Excellent">Excellent</option>
                      <option value="Very Good">Very Good</option>
                      <option value="Good">Good</option>
                      <option value="Fair">Fair</option>
                      <option value="Poor">Poor</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Cut ความสมมาตร</label>
                    <select name="symmetry_cut" id="symmetry_cut" class="form-control">
                      <option value="N/A">N/A</option>
                      <option value="Excellent">Excellent</option>
                      <option value="Very Good">Very Good</option>
                      <option value="Good">Good</option>
                      <option value="Fair">Fair</option>
                      <option value="Poor">Poor</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Cut ความเงา</label>
                    <select name="polish_cut" id="polish_cut" class="form-control">
                      <option value="N/A">N/A</option>
                      <option value="Excellent">Excellent</option>
                      <option value="Very Good">Very Good</option>
                      <option value="Good">Good</option>
                      <option value="Fair">Fair</option>
                      <option value="Poor">Poor</option>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Fluorescent</label>
                    <select name="fluorescent" id="fluorescent" class="form-control">
                      <option value="N/A">N/A</option>
                      <option value="None">None</option>
                      <option value="Faint">Faint</option>
                      <option value="Medium">Medium</option>
                      <option value="Strong">Strong</option>
                      <option value="Very Strong">Very Strong</option>
                    </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">Shape(รูปทรง)</label>
                    <select name="diamond_shape" id="diamond_shape" class="form-control">
                      <option value="Round">Round</option>
                      <option value="Oval">Oval</option>
                      <option value="Emerald">Emerald</option>
                      <option value="Sq.emerald">Sq.emerald</option>
                      <option value="Princess">Princess</option>
                      <option value="Pear">Pear</option>
                      <option value="Heart">Heart</option>
                      <option value="Cushion">Cushion</option>
                      <option value="Radiant">Radiant</option>
                    </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">เลขใบ Cer</label>
                    <input type="text" class="form-control" id="certificate" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ชื่อสถาบัน Cer</label>
                    <input type="text" class="form-control" id="name_certificate" placeholder="" value="">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="">รูปภาพใบเซอร์</label>
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

</body>
</html>

