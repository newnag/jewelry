<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/stock-jewelry-body.php') ;
include('../../classes/stock-jewelry-order.php') ;
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

$data_product = array(
  "conn" => $conn,
  "paper_no" => "",
  "type_product" => "",
  "customer_id" => "",
  "customer_name" => "",
  "detail" => "",
  "order_date" => "",
  "estimate_price" => "",
  "deposit" => "",
  "price" => "",
  "cost" => "",
  "weight" => "",
  "size" => "",
  "supplier_body_id" => "",
  "supplier_body_name" => "",
  "supplier_body_lot" => "",
  "supplier_body_weight" => "",
  "supplier_body_cost" => "",
  "supplier_body_type" => "",
  "supplier_loose" => "",
  "id" => $_GET['id']
);

///////////////////////////////////////////////
// query zone
///////////////////////////////////////////////

$sql = new Stock_jewelry_body($data);
$query_body = $sql->get();

$sql_product = new Stock_jewelry_order($data_product);
$query = $sql_product->get_data_id();
$get_pic = $sql_product->get_pic($_GET['id']);

?>

<style>
    .btn-tb{
        margin-right: 5px;
    }

    .main-sidebar{
      height: 1500px!important;
    }

    .keed{
      margin: 2em 0;
      border: 1px solid #d9d5d5;
    }
</style>

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
              <li class="breadcrumb-item active">ข้อมูลสต็อกเพชร</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <input type="hidden" id="order_id" value="<?=$query['id']?>">
    <input type="hidden" id="paper_no" value="<?=$query['paper_no']?>">

    <?php
      $query_loose = $sql_product->get_loose_item($query['supplier_loose']);
      $data_loose = json_decode($query['supplier_loose']);
    ?>

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
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
                    </tr>
                  </thead>
                    
                  <tbody>
                    <?php
                      for($i=0;$i<count($query_loose);$i++){
                        echo "
                          <tr>
                            <th>".$query_loose[$i]['supplier']."</th>
                            <th>".$query_loose[$i]['diamond_shape']."</th>
                            <th>".$query_loose[$i]['weight']."</th>
                            <th>".$data_loose[$i]->amount."</th>
                            <th>".$query_loose[$i]['price']."</th>
                          </tr>
                        ";
                      }
                    ?>
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
                    <label for="">เลือกตัวเรือน</label>
                    <input type="text" class="form-control" id="body_name" placeholder="" value="<?=$query['supplier_body_name']?>" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">น้ำหนัก</label>
                    <input type="text" class="form-control" id="body_weight" placeholder="" value="<?=$query['supplier_body_weight']?>" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ต้นทุน</label>
                    <input type="text" class="form-control" id="body_cost" placeholder="" value="<?=$query['supplier_body_cost']?>" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-4">
                <label for="">รหัสลูกค้า: </label>
                <label for="" style="font-weight: 400;"><?=$query['id_customer']?></label>
              </div>

              <div class="col-4">
                <label for="">ชื่อลูกค้า: </label>
                <label for="" style="font-weight: 400;"><?=$query['customer_name']?></label>
              </div>

              <div class="col-4">
                <label for="">บัตรประชาชน: </label>
                <label for="" style="font-weight: 400;"><?=$query['id_no']?></label>
              </div>
            </div>

            <div class="keed"></div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ประเภทสินค้า</label>
                    <input type="text" class="form-control" id="product_type" placeholder="" value="<?=$query['type_name']?>" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">น้ำหนัก(กรัม)</label>
                    <input type="number" class="form-control" id="weight" placeholder="" value="<?=$query['weight']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ไซส์</label>
                    <input type="number" class="form-control" id="size" placeholder="" value="<?=$query['size']?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control" id="detail" rows="3" placeholder=""><?=$query['detail']?></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">วันที่สั่งทำ</label>
                    <input type="test" class="form-control" id="stock_date" placeholder="" value="<?=$query['order_date']?>" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ราคาต้นทุน</label>
                    <input type="number" class="form-control" id="cost" placeholder="" value="<?=$query['cost']?>">
                </div>
              </div>  
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ราคาประเมิน</label>
                    <input type="number" class="form-control" id="estimate_price" placeholder="" value="<?=$query['estimate_price']?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">มัดจำ</label>
                    <input type="number" class="form-control" id="deposit" placeholder="" value="<?=$query['deposit']?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ราคาขาย</label>
                    <input type="number" class="form-control" id="price" placeholder="" value="<?=$query['price']?>">
                </div>
              </div>  
            </div>

            <div class="row">
                <div class="col-4">
                  <div class="form-group">
                      <label for="">สถานะ</label>
                      <select class="form-control" id="status_product">
                        <?php
                          $txt = array(
                            "สั่งทำ","รอลูกค้ารับ","ปิดการขาย"
                          );
                          $select_status = $query['status'];
                          $status_txt = $txt[$select_status-1];
                          echo '<option value="'.$select_status.'">'.$status_txt.'</option>';

                          $txt_diff = array_search($status_txt,$txt);
                          for($i=0;$i<count($txt);$i++){
                            $val = $i+1;
                            if($i != $txt_diff){
                              echo '<option value="'.$val.'">'.$txt[$i].'</option>';
                            }
                          }
                        ?>
                      </select>
                  </div>
                </div>
            </div>

            <?php
              // Zone setting pic
              $path_default = "../../asset/img/default.jpg";
              $path_pic = array($path_default,$path_default,$path_default);
              $dir_pic = "../../uploads/stock-order-jewelry/";

              if($get_pic['path_1'] != ""){
                $path_pic[0] = $dir_pic.$get_pic['path_1'];
              }

              if($get_pic['path_2'] != ""){
                $path_pic[1] = $dir_pic.$get_pic['path_2'];
              }

              if($get_pic['path_3'] != ""){
                $path_pic[2] = $dir_pic.$get_pic['path_3'];
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

                <div class="col-4">
                  <div class="form-group">
                      <label for="">รูปที่ 2</label>
                      <div class="input-group">
                          <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[1]?>" alt=""></figure>
                      </div>
                  </div>
                </div>

                <div class="col-4">
                  <div class="form-group">
                      <label for="">รูปที่ 3</label>
                      <div class="input-group">
                          <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[2]?>" alt=""></figure>
                      </div>
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-auto"><button class="btn btn-primary" onclick="update()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
                <div class="col-auto"><button class="btn btn-danger" onclick="item_delete(<?=$query['id']?>)">ลบ</button></div>
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

