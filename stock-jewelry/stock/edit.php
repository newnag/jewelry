<?php 

include('../../classes/auth.php') ;
include('../../classes/stock-jewelry-product.php') ;
include('../../config/db.php');
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
    "type_build" => "",
    "stock_date" => "",
    "type_product" => "",
    "product_no" => "",
    "detail" => "",
    "size" => "",
    "weight" => "",
    "cost" => "",
    "cost_id" => "",
    "price_sale" => "",
    "price_id" => "",
    "sale_date" => "",
    "status_product" => "",
    "reuse_product" => "",
    "reuse_detail" => "",
    "id" => $_GET['id']
  );

  ///////////////////////////////////////////////////////////////
  // query data
  $stock = new Stock_jewelry_product($data);
  $get_data = $stock->get_data();
  $get_type = $stock->get_data_type($get_data['type_product']);
  $get_type_all = $stock->get_type_all(3);
  $get_cate_all = $stock->get_cate_all($get_type['type_id']);
  $get_assembly = $stock->get_assembly($_GET['id']);
  $get_pic = $stock->get_pic_product($get_data['id']);
  
  $get_history = $stock->get_history($_GET['id']);

  // print_r($get_history);
  ///////////////////////////////////////////////////////////////
?>


<style>
    .btn-tb{
        margin-right: 5px;
    }

    .img-edit{
      height: 300px;
    }

    /* .main-sidebar{
      min-height: 1600px!important;
    } */
    .content-wrapper{
      min-height: 2000px!important;
    }
</style>

<input type="hidden" id="item_id" value="<?=$get_data['id']?>">
<input type="hidden" id="admin_id" value="<?=$_SESSION['admin_id']?>">

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
              <li class="breadcrumb-item active">ข้อมูลสต็อคทอง</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="card">

          <?php
            $raw_loose_data = json_decode($get_assembly['loose_diamond']);
            $arr_loose_data = array();

            for($i=0;$i<count($raw_loose_data);$i++){
              $data_loose = $stock->get_data_loose($raw_loose_data[$i]->loose_id);
              $arr_loose_data[$i] = $data_loose;
            }
          ?>
          <div class="card-body">
            <div class="row">
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
                      for($i=0;$i<count($arr_loose_data);$i++){
                        echo "
                          <tr>
                            <td>".$arr_loose_data[$i]['supplier']."</td>
                            <td>".$arr_loose_data[$i]['diamond_shape']."</td>
                            <td>".$arr_loose_data[$i]['weight']."</td>
                            <td>".$raw_loose_data[$i]->amount."</td>
                            <td>".$arr_loose_data[$i]['price']."</td>
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
          <?php
            // query Body
            $query_body = $stock->get_data_body_id($get_assembly['body_id']);
          ?>

          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">Supplier</label>
                    <input type="text" class="form-control" id="select_body" placeholder="" value="<?=$query_body['supplier']?>" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">น้ำหนัก</label>
                    <input type="text" class="form-control" id="body_weight" placeholder="" value="<?=$query_body['weight']?>" readonly>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ต้นทุน</label>
                    <input type="text" class="form-control" id="body_cost" placeholder="" value="<?=$query_body['price']?>" readonly>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">ประเภทการผลิต</label>
                    <select class="form-control" id="type_build">
                      <?php
                        $txt = array(
                          "ผลิตเอง","นำเข้า","สินค้าหมุนเวียน","หลุดจำนำ"
                        );
                        $select_status = $get_data['type_build'];
                        echo '<option value="'.$select_status.'">'.$select_status.'</option>';

                        for($i=0;$i<count($txt);$i++){
                          if($select_status != $txt[$i]){
                            echo '<option value="'.$txt[$i].'">'.$txt[$i].'</option>';
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
                    <label for="">ชื่อสินค้า</label>
                    <input type="text" class="form-control" id="product_name" placeholder="" value="<?=$get_data['product_name']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">รหัสสินค้า</label>
                    <input type="text" class="form-control" id="product_no" placeholder="" value="<?=$get_data['product_no']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ประเภทสินค้า</label>
                    <select class="form-control" id="product_type">
                      <?php
                        echo '<option value="'.$get_type['type_id'].'">'.$get_type['type_name'].'</option>';

                        for($i=0;$i<count($get_type_all);$i++){
                          if($get_type_all[$i]['type_name'] != $get_type['type_name']){
                            echo '<option value="'.$get_type_all[$i]['type_id'].'">'.$get_type_all[$i]['type_name'].'</option>';
                          }
                        }
                      ?>
                    </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">หมวดหมู่สินค้า</label>
                    <select class="form-control" id="product_cate">
                      <?php
                        echo '<option value="'.$get_type['cate_id'].'">'.$get_type['cate_name'].'</option>';

                        for($i=0;$i<count($get_cate_all);$i++){
                          if($get_type['cate_id'] != $get_cate_all[$i]['id']){
                            echo '<option value="'.$get_cate_all[$i]['id'].'">'.$get_cate_all[$i]['cate_name'].'</option>';
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
                    <input type="number" class="form-control" id="weight" placeholder="" value="<?=$get_data['weight']?>">
                    <input type="hidden" id="old_weight" placeholder="" value="<?=$get_data['weight']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ไซส์</label>
                    <input type="number" class="form-control" id="size" placeholder="" value="<?=$get_data['size']?>">
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control" id="detail" rows="3" placeholder=""><?=$get_data['detail']?></textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                    <label for="">วันที่นำเข้า</label>
                    <input type="date" class="form-control" id="stock_date" placeholder="" value="<?=$get_data['stock_date']?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                    <label for="">รหัสราคาต้นทุน</label>
                    <input type="text" class="form-control" id="cost_id" placeholder="" value="<?=$get_data['cost_id']?>">
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">ราคาต้นทุน</label>
                    <input type="number" class="form-control" id="cost" placeholder="" value="<?=$get_data['cost']?>">
                </div>
              </div>  

              <div class="col-md-2">
                <div class="form-group">
                    <label for="">ต้นทุนอื่นๆ</label>
                    <input type="number" class="form-control" id="other_cost" placeholder="" value="<?=$get_data['other_cost']?>">
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
                            "สต็อก","ขายแล้ว"
                          );
                          $select_status = $get_data['status_product'];
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

                <div class="col-2" style="margin: auto 0;">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="show_catalog" 
                      <?php
                        if($get_data['show_front'] == 1){
                          echo 'checked';
                        }
                      ?>
                    >
                    <label class="form-check-label" for="show_catalog">แสดงหน้าร้าน</label>
                  </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                  <div class="form-group">
                      <label for="">สินค้าหมุนเวียน</label>
                      <select class="form-control" id="reuse_product">
                        <?php
                          $txt = array(
                            "ไม่มี","รับซื้อคืน","ขายซ้ำ"
                          );
                          $select_status = $get_data['reuse_product'];
                          $status_txt = $txt[$select_status];
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

                <div class="col-8">
                  <div class="form-group">
                      <label for="">รายละเอียดสินค้าหมุนเวียน</label>
                      <textarea class="form-control" id="reuse_detail" rows="3" placeholder="" disabled><?=$get_data['reuse_detail']?></textarea>
                  </div>
                </div>
            </div>

            <?php
              // Zone setting pic
              $path_default = "../../asset/img/default.jpg";
              $path_pic = array($path_default,$path_default,$path_default);
              $dir_pic = "../../uploads/stock-jewelry/";

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
                        <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[1]?>" alt=""></figure>
                      </div>
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
                        <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[2]?>" alt=""></figure>
                      </div>
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
                <div class="col-auto"><button class="btn btn-primary" onclick="update()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
                <div class="col-auto"><button class="btn btn-danger" onclick="item_delete(<?=$_GET['id']?>)">ลบ</button></div>
            </div>

            <div class="row mt-4">
              <div class="col-12">
                <table id="table-history" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>วันที่</th>
                      <th>ชื่อผู้เปลี่ยนข้อมูล</th>
                      <th>น้ำหนักที่เปลี่ยน</th>
                    </tr>
                  </thead>
                    
                  <tbody>
                    <?php
                      for($i=0;$i<count($get_history);$i++){
                        echo "
                          <tr>
                            <td>".$get_history[$i]['update_date']."</td>
                            <td>".$get_history[$i]['username']."</td>
                            <td>".$get_history[$i]['weight_change']."</td>
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
      </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<script src="js/stock.js"></script>

</body>
</html>

