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
      height: 1500px!important;
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
              <li class="breadcrumb-item active">ข้อมูลสต็อกเพชร</li>
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
              <div class="col-md-4 mr-5">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modal-add-loose">เพิ่มเพชรร่วง</button>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-12">
                <table id="table-loose" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Supplier</th>
                      <th>รูปทรงเพชร</th>
                      <th>น้ำหนัก(กะรัต)</th>
                      <th>จำนวน</th>
                      <th>ต้นทุน</th>
                      <th>ลบ</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                  
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row mb-4">
              <h5>ตัวเรือน</h5>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">Supplier</label>
                    <input type="text" class="form-control" id="body_supplier" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ต้นทุน</label>
                    <input type="number" class="form-control" id="body_cost" placeholder="" value="0">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">น้ำหนัก</label>
                    <input type="number" class="form-control" id="body_weight" placeholder="" value="0">
                </div>
              </div>

              <div class="col-md-4">
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

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">เปอร์เซ็นทอง</label>
                    <input type="number" class="form-control" id="body_percent" placeholder="" value="0">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ประเภท</label>
                    <select class="form-control" id="type_product">
                      <option value="">เลือกประเภทสินค้า</option> 
                      <option value="18">แหวนเพชร</option>
                      <option value="19">ต่างหูเพชร</option>
                      <option value="20">จี้เพชร</option>
                      <option value="21">สร้อยคอ</option>
                      <option value="22">สร้อยข้อมือ</option>
                      <option value="23">กำไร</option>
                      <option value="24">เครื่องประดับพลอย</option>
                    </select>
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
                    <label for="">รหัสสินค้า</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ประเภทสินค้า</label>
                    <select class="form-control" id="product_type">

                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">หมวดหมู่สินค้า</label>
                    <select class="form-control" id="product_cate">
                      
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนัก(กรัม)</label>
                    <input type="number" class="form-control" id="weight" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ไซส์</label>
                    <input type="number" class="form-control" id="size" placeholder="" value="">
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
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">วันที่นำเข้า</label>
                    <input type="date" class="form-control" id="stock_date" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">รหัสราคาต้นทุน</label>
                    <input type="text" class="form-control" id="cost_id" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">ราคาต้นทุน</label>
                    <input type="text" class="form-control" id="cost" placeholder="" value="">
                </div>
              </div>  
            </div>

            <div class="row">
                <div class="col-4">
                  <div class="form-group">
                      <label for="">สถานะ</label>
                      <select class="form-control" id="status_product">
                        <option value="1">สต็อก</option>
                      </select>
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
                      <label for="">รายละเอียดสินค้าหมุนเวียน</label>
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
                <div class="col-auto"><button class="btn btn-primary" onclick="add_import()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<div class="modal fade show" id="modal-add-loose" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">เพิ่มเพชรร่วง</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="add-loose-item">Supplier</label>
          <input type="text" class="form-control" id="modal_supplie">
        </div>
        <div class="form-group">
          <label for="add-loose-item">รูปทรงเพชร</label>
          <input type="text" class="form-control" id="modal_shape">
        </div>
        <div class="form-group">
          <label for="add-loose-item">น้ำหนัก(กะรัต)</label>
          <input type="text" class="form-control" id="modal_weight">
        </div>
        <div class="form-group">
          <label for="add-loose-amount">จำนวน</label>
          <input type="number" class="form-control" min="0" id="modal_amount" placeholder="">
        </div>
        <div class="form-group">
          <label for="add-loose-item">ต้นทุน</label>
          <input type="text" class="form-control" id="modal_cost">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="add_loose_modal()">เพิ่ม</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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

