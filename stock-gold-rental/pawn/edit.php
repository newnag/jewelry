<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/gold-rental.php') ;

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
    "cus_sale_id" => "",
    "product_name" => "",
    "price_rental" => "",
    "interest" => "",
    "detail" => "",
    "value" => "",
    "id" => $_GET['id']
  );

  //////////// query zone //////////////

  $sql = new Gold_rental($data);
  $get_query = $sql->getdata();
  $get_history = $sql->get_trans();
?>


<style>
    .btn-tb{
        margin-right: 5px;
    }

    .content-wrapper{
      height: fit-content;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>แก้ไขรายการ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">การจำนำ</li>
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
              <div class="col-3"><h2>ชื่อลูกค้า</h2></div>
            </div>

            <div class="keed"></div>

            <div class="row mt-3"> 
              <div class="col-12">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group row">
                      <label class="col-sm-1 col-form-label">รหัสลูกค้า: </label>
                      <div class="col-9" style="display:flex;align-items: center;">
                        <p class="" style="margin:0;" id="customer_id"><?=$get_query['id_customer']?></p>
                      </div>
                    </div>
                    
                    <input type="hidden" id="cus_sale_id" value="<?=$get_query['id_customer']?>">
                  </div>
                </div>

                <div class="row">
                  <div class="col-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">ชื่อ-สกุล</label>
                      <div class="col-9">
                        <input type="text" class="form-control read-gold " id="cus_name" readonly value="<?=$get_query['fullname']?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">เลขประจำตัว</label>
                      <div class="col-7">
                        <input type="text" class="form-control read-gold " id="id_no" readonly value="<?=$get_query['id_no']?>">
                      </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">เบอร์โทร</label>
                      <div class="col-7">
                        <input type="text" class="form-control read-gold " id="phone" readonly value="<?=$get_query['phone']?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-5">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">ที่อยู่</label>
                      <div class="col-10">
                        <textarea name="" id="address" class="form-control read-gold" cols="30" rows="6" readonly><?=$get_query['address']?></textarea>
                      </div>
                    </div>
                  </div>

                  <div class="col-auto">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">เพศ</label>
                      <div class="col-6">
                        <input type="text" class="form-control read-gold" id="sex" readonly value="<?=$get_query['sex']?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">ได้รับคะแนน</label>
                      <div class="col-8">
                        <input type="text" class="form-control read-gold" id="recive_point" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="col-auto">
                    <div class="form-group row">
                      <label class="col-sm-3 col-form-label">วันเกิด</label>
                      <div class="col-9">
                        <input type="text" class="form-control read-gold " id="dob" readonly value="<?=$get_query['DOB']?>">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">คะแนนรวม</label>
                      <div class="col-8">
                        <input type="text" class="form-control read-gold " id="point" readonly value="<?=$get_query['point']?>">
                      </div>
                    </div>
                  </div>
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
                    <label for="">ชื่อสินค้า</label>
                    <input type="text" class="form-control" id="product_name"  placeholder="" value="<?=$get_query['product_name']?>">
                    <input type="hidden" id="item_id" value="<?=$_GET['id']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ราคาต้น</label>
                    <input type="text" class="form-control" id="price_rental" min="0" placeholder="" value="<?=$get_query['price_rental']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">ดอกต่อเดือน</label>
                    <input type="text" class="form-control" id="interest" min="0" placeholder="" value="<?=$get_query['interest']?>">
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                    <label for="">มูลค่าสินค้า</label>
                    <input type="text" class="form-control" id="value" min="0" placeholder="" value="<?=$get_query['value']?>">
                </div>
              </div>
            </div>

            <?php
              // Zone setting pic
              $path_default = "../../asset/img/default.jpg";
              $path_pic = array($path_default);
              $dir_pic = "../../uploads/gold-rental/";

              if($get_query['pic_path'] != ""){
                $path_pic[0] = $dir_pic.$get_query['pic_path'];
              }
            ?>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                    <label for="">รูปสินค้า</label>
                    <div class="input-group">
                      <figure class="figure"><img class="img-fluid img-edit" src="<?=$path_pic[0]?>" alt=""></figure>
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label for="">รายละเอียด</label>
                    <textarea class="form-control" id="detail" rows="4" placeholder=""><?=$get_query['detail']?></textarea>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-auto"><button class="btn btn-primary" onclick="update()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-secondary" onclick="goback()">ปิด</button></div>
                <div class="col-auto"><button class="btn btn-danger" onclick="item_delete(<?=$_GET['id']?>)">ลบ</button></div>
                <div class="col-auto"><button class="btn btn-warning" onclick="">ปิดการจำนำ</button></div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <table id="table-history" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>วันที่</th>
                      <th>ดอกที่ต่อ</th>
                      <!-- <th>จำนวนเงินที่ต้องเก็บ</th> -->
                    </tr>
                  </thead>
                    
                  <tbody>
                    <?php
                      for($i=0;$i<count($get_history);$i++){
                        echo "
                          <tr>
                            <td>".$get_history[$i]['create_date']."</td>
                            <td>".$get_history[$i]['interest']."</td>
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

