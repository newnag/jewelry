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
  "color" => "",
  "type" => "",
  "si" => "",
  "weight_total" => "",
  "percent_gold" => "",
  "id" => $_GET['id']
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_jewelry_body($data);
$query = $sql->get_data();
$query_type = $sql->get_data_type($query['type']);
$get_pic = $sql->get_pic($query['id']);
?>

<style>
    .btn-tb{
        margin-right: 5px;
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
              <li class="breadcrumb-item active">สต็อกตัวเรือน</li>
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
                    <input type="number" class="form-control" id="price" min="0" placeholder="" value="<?=$query['price']?>">
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
                    <label for="">เปอร์เซ็นทอง</label>
                    <select name="" id="percent_gold" class="form-control">
                      <?php
                        $txt_percent = array(
                          "90","18K"
                        );
                        $percent_gold = $query['percent_gold'];
                        if($percent_gold == "90" || $percent_gold == "18K"){
                          echo '<option value="'.$percent_gold.'">'.$percent_gold.'</option>';
                          for($i=0;$i<count($txt_percent);$i++){
                            if($txt_percent[$i] != $percent_gold){
                              echo '<option value="'.$txt_percent[$i].'">'.$txt_percent[$i].'</option>';
                            }
                          }
                          echo '<option value="other">อื่นๆ</option>';
                        }
                        else{
                          echo '<option value="other">อื่นๆ</option>';
                          for($i=0;$i<count($txt_percent);$i++){
                            echo '<option value="'.$txt_percent[$i].'">'.$txt_percent[$i].'</option>';
                          }
                        }
                      ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">เปอร์เซ็นอื่นๆ</label>
                    <?php
                      if($percent_gold == "90" || $percent_gold == "18K"){
                        echo '<input type="text" class="form-control" id="percent_gold_other"  value="" disabled>';
                      }
                      else{
                        echo '<input type="text" class="form-control" id="percent_gold_other"  value="'.$percent_gold.'">';
                      }
                    ?>
                    
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">สีทอง</label>
                    <select name="" id="color" class="form-control">
                      <?php
                        $txt_color = array(
                          "WG","YG","PG","RG","PT","S"
                        );

                        $select_color= $query['gold'];
                        echo '<option value="'.$select_color.'">'.$select_color.'</option>';
                        
                        for($i=0;$i<count($txt_color);$i++){
                          if($txt_color[$i] != $select_color){
                            echo '<option value="'.$txt_color[$i].'">'.$txt_color[$i].'</option>';
                          }
                        }
                      ?>
                    </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนัก(กรัม)</label>
                    <input type="number" class="form-control" id="weight" min="0" placeholder="" value="<?=$query['weight']?>" >
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ค่าซิ</label>
                    <input type="number" class="form-control" id="si" min="0" placeholder="" value="<?=$query['percent_si']?>" >
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนักรวมซิ</label>
                    <input type="number" class="form-control" id="weight_total" min="0" placeholder="" value="<?=$query['total_weight_si']?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ประเภท</label>
                    <select class="form-control" id="product_type">
                      <?php
                          echo '<option value="'.$query_type['id'].'">'.$query_type['type_name'].'</option>';
                      ?>
                    </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                    <label for="">Note</label>
                    <textarea name="" id="note" class="form-control" cols="30" rows="4"><?=$query['detail']?></textarea>
                </div>
              </div>
            </div>

            <?php
              // Zone setting pic
              $path_default = "../../asset/img/default.jpg";
              $path_pic = array($path_default);
              $dir_pic = "../../uploads/stock-body/";

              if($get_pic['path'] != ""){
                $path_pic[0] = $dir_pic.$get_pic['path'];
              }
            ?>

            <div class="row">
              <div class="col-4">
                <div class="form-group">
                    <label for="">รูปที่ 1</label>
                    <div class="input-group">
                      <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[0]?>" alt=""></figure>
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

<script>
  get_type()
</script>

</body>
</html>

