<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-jewelry-loose.php') ;
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
  "supplier_lot" => "",
  "stock_date" => "",
  "price" => "",
  "weight" => "",
  "amount" => "",
  "weight_total" => "",
  "size" => "",
  "color" => "",
  "clarity" => "",
  "proportion_cut" => "",
  "symmetry_cut" => "",
  "polish_cut" => "",
  "diamond_shape" => "",
  "certificate" => "",
  "name_certificate" => "",
  "id" => $_GET['id']
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_jewelry_loose($data);
$query = $sql->get_data();
$get_pic = $sql->get_pic($query['id']);
?>

<style>
    .btn-tb{
        margin-right: 5px;
    }

    .img-edit{
      height:300px;
    }

    .main-sidebar{
      height: 900px!important;
    }
</style>

<input type="hidden" id="item_id" value="<?=$query['id']?>">

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>แก้ไขสินค้า</h1>
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
                    <input type="text" class="form-control" id="supplier" value="<?=$query['supplier']?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">Supplier Lot</label>
                    <input type="text" class="form-control" id="supplier_lot" value="<?=$query['lot_supplier']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">วันที่นำเข้า</label>
                    <input type="date" class="form-control" id="stock_date" value="<?=$query['stock_date']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ราคาต้นทุน</label>
                    <input type="number" class="form-control" id="price" min="0" placeholder=""value="<?=$query['price']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนัก(กะรัต)</label>
                    <input type="number" class="form-control" id="weight" min="0" placeholder="" value="<?=$query['weight']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนักรวม(ห่อ)</label>
                    <input type="number" class="form-control" id="weight_total" min="0" placeholder="" value="<?=$query['total_weight']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ไซส์ (mm)</label>
                    <input type="text" class="form-control" id="size" min="0" placeholder="" value="<?=$query['size']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">จำนวน</label>
                    <input type="number" class="form-control" id="amount" min="0" placeholder="" value="<?=$query['amount']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">สี</label>
                    <select name="color" id="color" class="form-control">
                    <?php
                      $txt = array(
                        "D (100)","E (99)","F (98)","G (97)","H (96)","I (95)","J (94)","K (93)","L (92)","M-Z"
                      );
                      $select_color = $query['color'];
                      echo '<option value="'.$select_color.'">'.$select_color.'</option>';
                      
                      for($i=0;$i<count($txt);$i++){
                        if($txt[$i] != $select_color){
                          echo '<option value="'.$txt[$i].'">'.$txt[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ความบริสุทธิ์</label>
                    <select name="clarity" id="clarity" class="form-control">
                    <?php
                      $txt1 = array(
                        "FL/IF","VVS1","VVS2","VS1","VS2","SI1","SI2","I1","I2","I3"
                      );
                      $select_clarity = $query['clarity'];
                      echo '<option value="'.$select_clarity.'">'.$select_clarity.'</option>';
                      
                      for($i=0;$i<count($txt1);$i++){
                        if($txt1[$i] != $select_clarity){
                          echo '<option value="'.$txt1[$i].'">'.$txt1[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">อื่นๆ</label>
                    <input type="text" class="form-control" name="other" id="other" value="<?=$query['other']?>">
                </div>
              </div>
            </div>

            <?php
              $txt_cut = array(
                "N/A","Excellent","Very Good","Good","Fair","Poor"
              );
              $txt_flu = array(
                "N/A","None","Faint","Medium","Strong","Very Strong"
              )
            ?>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Cut สัดส่วน</label>
                    <select name="proportion_cut" id="proportion_cut" class="form-control">
                    <?php
                      $select_prop_cut= $query['proportion_cut'];
                      echo '<option value="'.$select_prop_cut.'">'.$select_prop_cut.'</option>';
                      
                      for($i=0;$i<count($txt_cut);$i++){
                        if($txt_cut[$i] != $select_prop_cut){
                          echo '<option value="'.$txt_cut[$i].'">'.$txt_cut[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Cut ความสมมาตร</label>
                    <select name="symmetry_cut" id="symmetry_cut" class="form-control">
                    <?php
                      $select_sym_cut= $query['symmetry_cut'];
                      echo '<option value="'.$select_sym_cut.'">'.$select_sym_cut.'</option>';
                      
                      for($i=0;$i<count($txt_cut);$i++){
                        if($txt_cut[$i] != $select_sym_cut){
                          echo '<option value="'.$txt_cut[$i].'">'.$txt_cut[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Cut ความเงา</label>
                    <select name="polish_cut" id="polish_cut" class="form-control">
                    <?php
                      $select_pol_cut= $query['polish_cut'];
                      echo '<option value="'.$select_pol_cut.'">'.$select_pol_cut.'</option>';
                      
                      for($i=0;$i<count($txt_cut);$i++){
                        if($txt_cut[$i] != $select_pol_cut){
                          echo '<option value="'.$txt_cut[$i].'">'.$txt_cut[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">Fluorescent</label>
                    <select name="fluorescent" id="fluorescent" class="form-control">
                    <?php
                      $select_flu= $query['fluorescent'];
                      echo '<option value="'.$select_flu.'">'.$select_flu.'</option>';
                      
                      for($i=0;$i<count($txt_flu);$i++){
                        if($txt_flu[$i] != $select_flu){
                          echo '<option value="'.$txt_flu[$i].'">'.$txt_flu[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">Shape(รูปทรง)</label>
                    <select name="diamond_shape" id="diamond_shape" class="form-control">
                    <?php
                      $txt_shape = array(
                        "Round","Oval","Emerald","Sq.emerald","Princess","Pear","Heart","Cushion","Radiant"
                      );

                      $select_shape= $query['diamond_shape'];
                      echo '<option value="'.$select_shape.'">'.$select_shape.'</option>';
                      
                      for($i=0;$i<count($txt_shape);$i++){
                        if($txt_shape[$i] != $select_shape){
                          echo '<option value="'.$txt_shape[$i].'">'.$txt_shape[$i].'</option>';
                        }
                      }
                    ?>
                    </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">เลขใบ Cer</label>
                    <input type="text" class="form-control" id="certificate" placeholder="" value="<?=$query['certificate']?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ชื่อสถาบัน Cer</label>
                    <input type="text" class="form-control" id="name_certificate" placeholder="" value="<?=$query['name_certificate']?>">
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
                <div class="col-auto"><button class="btn btn-primary" onclick="update()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
                <div class="col-auto"><button class="btn btn-danger" onclick="item_delete(<?=$_GET['id']?>)">ลบ</button></div>
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

