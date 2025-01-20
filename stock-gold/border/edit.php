<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/stock-gold.php');
include('../../classes/supplier.php') ;

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
    "supplier_type" => "",
    "product_no" => "",
    "product_cate" => "",
    "weight" => "",
    "detail" => "",
    "import_date" => "",
    "size" => "",
    "cost_id" => "",
    "cost" => "",
    "cost_price" => "",
    "wage" => "",
    "cost_wage_id" => "",
    "cost_wage" => "",
    "sale_date" => "",
    "price_id" => "",
    "price" => "",
    "status" => "",
    "id" => $_GET['id']
  );

  ///////////////////////////////////////////////////////////////
  // query data
  $stock = new Stock_gold($data);
  $get_data = $stock->get_data();
  $get_type = $stock->get_data_type($get_data[0]['type_product']);
  $get_pic = $stock->get_pic($get_data[0]['id']);

  ///////////////////////////////////////////////////////////////
?>

<style>
    .btn-tb{
        margin-right: 5px;
    }

    .content-wrapper{
      height: fit-content;
    }

    .img-edit{
      height: 300px;
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

<input type="hidden" id="item_id" value="<?=$get_data[0]['id']?>">

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>แก้ไขสินค้า</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">กรอบพระ</a></li>
              <li class="breadcrumb-item active">แก้ไขสินค้า</li>
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
                  <input type="text" class="form-control" id="product_no" placeholder="" value="<?=$get_data[0]['product_no']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ประเภท Supplier</label>
                    <select class="form-control" id="supplier_type">
                      <?php
                        echo '<option value="'.$get_data[0]['type_supplier'].'" selected>'.$get_data[0]['type_supplier'].'</option>';
                      ?>
                       
                       <?php
                        $data = array(
                          "conn" => $conn,
                          "supplier_name" => "",
                          "id" => ""
                        );
                        $sup = new Supplier($data);
                        $get_sup = $sup->get();

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
                      <?php
                        echo '<option value="'.$get_type[0]['type_id'].'">'.$get_type[0]['type_name'].'</option>';
                          
                      ?>
                    </select>
                </div>
              </div>
  
              <div class="col-md-2">
                <div class="form-group">
                    <label for="">หมวดหมู่สินค้า</label>
                    <select class="form-control" id="product_cate">
                      <?php
                        echo '<option value="'.$get_type[0]['id'].'">'.$get_type[0]['cate_name'].'</option>';
                          
                      ?>
                    </select>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">น้ำหนักทอง(กรัม)</label>
                    <input type="number" class="form-control" id="weight" placeholder="" min="0" value="<?=$get_data[0]['weight']?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control" id="detail" rows="4" placeholder=""><?=$get_data[0]['detail']?></textarea>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">ขนาด</label>
                    <input type="text" class="form-control" id="size" placeholder="" value="<?=$get_data[0]['size']?>">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">วันที่นำเข้า</label>
                    <input type="date" class="form-control" id="import_date" placeholder="" value="<?=$get_data[0]['import_date']?>">
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

            <?php
              // Zone setting pic
              $path_default = "../../asset/img/default.jpg";
              $path_pic = array($path_default,$path_default,$path_default);
              $dir_pic = "../../uploads/stock-gold/";

              if(isset($get_pic[0])){
                $path_pic[0] = $dir_pic.$get_pic[0]['pic_path'];
              }

              if(isset($get_pic[1])){
                $path_pic[1] = $dir_pic.$get_pic[1]['pic_path'];
              }

              if(isset($get_pic[2])){
                $path_pic[2] = $dir_pic.$get_pic[2]['pic_path'];
              }
            ?>

            <div class="row">
              <div class="col-md-8" style="align-self: flex-end;">
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label for="">รูปที่ 1</label>
                        <div class="input-group">
                          <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[0]?>" alt=""></figure>
                        </div>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_1" onchange="change_name_pic(this)">
                            <input type="hidden" id="file_id_0" value="<?=$get_pic[0]['id']?>">
                            <label class="custom-file-label" for="file_1">Choose file</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                        <label for="">รูปที่ 2</label>
                        <div class="input-group">
                          <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[1]?>" alt=""></figure>
                        </div>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_2" onchange="change_name_pic(this)">
                            <input type="hidden" id="file_id_1" value="<?=$get_pic[1]['id']?>">
                            <label class="custom-file-label" for="file_2">Choose file</label>
                          </div>
                        </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group">
                        <label for="">รูปที่ 3</label>
                        <div class="input-group">
                          <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[2]?>" alt=""></figure>
                        </div>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file_3" onchange="change_name_pic(this)">
                            <input type="hidden" id="file_id_2" value="<?=$get_pic[2]['id']?>">
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
                        <input type="text" class="form-control" id="cost_id" placeholder="" value="<?=$get_data[0]['cost_id']?>">
                    </div>
                  </div>
    
                  <?php
                    if($_SESSION['role'] == 1){
                      echo '
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">ราคาทอง</label>
                              <input type="text" class="form-control" id="cost" placeholder="" value="'.$get_data[0]['cost'].'">
                          </div>
                        </div>  
                      ';
                    }
                  ?>
                  
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">รหัสต้นทุนค่ากำเหน็จ</label>
                        <input type="text" class="form-control" id="cost_wage_id" placeholder="" value="<?=$get_data[0]['cost_wage_id']?>">
                    </div>
                  </div>
    
                  <?php
                    if($_SESSION['role'] == 1){
                      echo '
                        <div class="col-md-6">
                          <div class="form-group">
                              <label for="">ต้นทุนค่ากำเหน็จ</label>
                              <input type="text" class="form-control" id="cost_wage" placeholder="" value="'.$get_data[0]['cost_wage'].'">
                          </div>
                        </div>  
                      ';
                    }
                  ?>
                </div>

                <div class="row">
                  <?php
                    if($_SESSION['role'] == 1){
                      echo '
                      <div class="col-md-6">
                        <div class="form-group">
                            <label for="">ราคาต้นทุน</label>
                            <input type="text" class="form-control" id="cost_price" placeholder="" value="'.$get_data[0]['cost_price'].'">
                        </div>
                      </div>
                      
                      ';
                    }
                  ?>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">ราคาค่ากำเหน็จ</label>
                        <input type="text" class="form-control" id="wage" placeholder="" value="<?=$get_data[0]['wage']?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-4">
              <?php
                if($_SESSION['role'] == 1){
                  echo '<div class="col-auto"><button class="btn btn-submit" onclick="update()">บันทึก</button></div>';
                  echo '<div class="col-auto"><button class="btn btn-danger" onclick="item_delete('.$_GET['id'].')">ลบ</button></div>';
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

