<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/supplier.php') ;

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

    .btn-submit{
      background-color: #d9a82a;
      color: #951b1e;
    }
    .btn-back{
      background-color: #d9a82a91;
      color: #951b1e;
    }

    input,select,textarea{
      border-color: #d9a82a!important;
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
              <li class="breadcrumb-item"><a href="#">ข้อมูลคลัง</a></li>
              <li class="breadcrumb-item active">เพิ่มสินค้า</li>
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
              <div class="col-md-3">
                <div class="form-group">
                  <label for="">รหัสสินค้า</label>
                  <input type="text" class="form-control" id="product_no" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ประเภท Supplier</label>
                    <select class="form-control" id="supplier_type">
                      <option value="">เลือก Supplier</option>
                      <?php
                        $data = array(
                          "conn" => $conn,
                          "supplier_name" => "",
                          "id" => ""
                        );
                        $sup = new Supplier($data);
                        $get_sup = $sup->get_by_type(2);

                        foreach($get_sup as $data){
                          echo '
                            <option value="'.$data['name'].'">'.$data['name'].'</option>
                          ';
                        }
                      ?>
                    </select>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">ประเภทสินค้า</label>
                    <select class="form-control" id="product_type">
  
                    </select>
                </div>
              </div>
  
              <div class="col-md-2">
                <div class="form-group">
                    <label for="">หมวดหมู่สินค้า</label>
                    <select class="form-control" id="product_cate">
                      
                    </select>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">น้ำหนักทอง(กรัม)</label>
                    <input type="number" class="form-control" id="weight" placeholder="" min="0" value="">
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

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">ขนาด</label>
                    <input type="text" class="form-control" id="size" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">วันที่นำเข้า</label>
                    <input type="date" class="form-control" id="import_date" placeholder="" value="">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">สถานะ</label>
                    <select class="form-control" id="status">
                      <option value="1">คลัง</option>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8" style="align-self: flex-end;">
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
              </div>

              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">รหัสราคาทอง</label>
                        <input type="text" class="form-control" id="cost_id" placeholder="" value="">
                    </div>
                  </div>
    
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">ราคาทอง</label>
                        <input type="text" class="form-control" id="cost" placeholder="" value="">
                    </div>
                  </div>  
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">รหัสต้นทุนค่ากำเหน็จ</label>
                        <input type="text" class="form-control" id="cost_wage_id" placeholder="" value="">
                    </div>
                  </div>
    
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">ต้นทุนค่ากำเหน็จ</label>
                        <input type="text" class="form-control" id="cost_wage" placeholder="" value="">
                    </div>
                  </div>  
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">ราคาต้นทุน</label>
                        <input type="text" class="form-control" id="cost_price" placeholder="" value="">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">ราคาค่ากำเหน็จ</label>
                        <input type="text" class="form-control" id="wage" placeholder="" value="">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <?php
                if($_SESSION['role'] == 1){
                  echo '<div class="col-auto"><button class="btn btn-submit" onclick="add()">บันทึก</button></div>';
                }
              ?>
                
              <div class="col-auto"><button class="btn btn-back" onclick="goback()">ปิด</button></div>
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

