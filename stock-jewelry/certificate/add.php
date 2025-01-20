<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-jewelry-body.php') ;
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
  "supplier" => "",
  "stock_date" => "",
  "price" => "",
  "weight" => "",
  "amount" => "",
  "type" => "",
  "id" => ""
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_jewelry_body($data);
$query_body = $sql->get();

?>

<style>
    .btn-tb{
        margin-right: 5px;
    }

    .main-sidebar{
      height: 1300px!important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>เพิ่มใบรับประกัน</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ใบรับประกัน</li>
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
                <input type="text" class="form-control" placeholder="รหัสสมาชิก">
              </div>

              <div class="col-md-1">
                <button class="btn btn-primary">ค้นหา</button>
              </div>

              <div class="col-md-2">
                <button class="btn btn-info">เพิ่มสมาชิก</button>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">รหัสสมาชิก</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="000001" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="หมีพลู ผองเพื่อน" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">บัตรประชาชน</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="123456678899" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">วันเกิด</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="22/04/2022" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">เบอร์โทรศัพท์</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="0888888888" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">เพศ</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="ชาย" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-9">
                <div class="form-group">
                    <label for="">ที่อยู่</label>
                    <textarea name="" class="form-control" id="" cols="30" rows="2" readonly>156 ต.ในเมือง อ.เมือง จ.ขอนแก่น 40000</textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <input type="text" class="form-control" placeholder="รหัสสินค้า">
              </div>

              <div class="col-md-4 mr-5">
                <button class="btn btn-primary">ค้นหาสินค้า</button>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-12">
                <table id="table-product" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>รหัสสินค้า</th>
                      <th>ประเภทการผลิต</th>
                      <th>ประเภทสินค้า</th>
                      <th>ไซส์</th>
                      <th>น้ำหนัก</th>
                      <th>ต้นทุน</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                    <tr>
                      <td>SKU0001</td>
                      <td>ผลิตเอง</td>
                      <td>แหวนเพชร</td>
                      <td>36</td>
                      <td>3</td>
                      <td>10,000</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">เลขใบรับประกัน</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">วันออกใบรับประกัน</label>
                    <input type="date" class="form-control" id="product_no" placeholder="" value="">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control" id="detail" rows="3" placeholder=""></textarea>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-4">
                  <div class="form-group">
                      <label for="">สินค้าหมุนเวียน</label>
                      <select class="form-control" id="reuse_product">
                        <option value="">ไม่มี</option>
                        <option value="1">รับซื้อคืน</option>
                        <option value="2">ขายซ้ำ</option>
                      </select>
                  </div>
                </div>

                <div class="col-8">
                  <div class="form-group">
                      <label for="">รายละเอียดการรับประกัน</label>
                      <textarea class="form-control" id="reuse_detail" rows="3" placeholder="" disabled></textarea>
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                  <div class="form-group">
                      <label for="">รูปที่ 1</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file_1" onchange="change_name_pic(this)">
                          <label class="custom-file-label" for="file_1">Choose file</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                      <label for="">รูปที่ 2</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file_2" onchange="change_name_pic(this)">
                          <label class="custom-file-label" for="file_2">Choose file</label>
                        </div>
                      </div>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                      <label for="">รูปที่ 3</label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" id="file_3" onchange="change_name_pic(this)">
                          <label class="custom-file-label" for="file_3">Choose file</label>
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
  get_loose_modal()
  get_type()
</script>

</body>
</html>

