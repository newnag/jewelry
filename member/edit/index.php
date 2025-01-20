<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/user.php');
include('../functions/check-login.php');

check_login($conn);

$data = array(
  "conn" => $conn,
  "fullname" => "",
  "sex" => "",
  "dob" => "",
  "phone" => "",
  "address" => "",
  "id_no" => "",
  "line_id" => "",
  "id_file" => "",
  "bookbank" => "",
  "id_customer" => "",
  "id" => $_GET['id']
);

$user = new User($data);
$get_user = $user->get_data();

// print_r($get_user);
$query = $get_user[0];

?>

<div class="wrapper">
<?php 
    include('../../template/header.php');
    include('../template/aside.php');
?>

<style>
  @media screen and (max-width:1365px){
    .pic1{
      margin-bottom: 10px;
    }
  }
</style>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>แก้ไขสมาชิก</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขสมาชิก</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <p>รหัสลูกค้า : <?=$query['id_customer']?></p>
                  <input type="hidden" id="user_id" value="<?=$query['id']?>">
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">ชื่อ-นามสกุล</label>
                    <input type="text" class="form-control" id="fullname" placeholder="" value="<?=$query['fullname']?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">เลขบัตรประชาชน</label>
                    <input type="text" class="form-control" id="id_no" placeholder="" value="<?=$query['id_no']?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">เพศ</label>
                    <select name="sex" id="sex" class="form-control">
                      <?php
                        if($query['sex'] != ""){
                          $sex = $query['sex'];
                          switch ($sex) {
                            case 'ชาย':
                              echo '
                              <option value="ชาย" selected>ชาย</option>
                              <option value="หญิง">หญิง</option>
                              ';
                              break;
                            
                            case 'หญิง':
                              echo '
                              <option value="หญิง" selected>หญิง</option>
                              <option value="ชาย">ชาย</option>
                              ';
                              break;
                          }
                        }
                        else{
                          echo '<option value="ชาย" selected>ชาย</option>
                          <option value="หญิง">หญิง</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>
              </div>

              <?php
                $raw_date = explode("-",$query['DOB']);
                $convert_year = intval($raw_date[0])+543;
                $dob = $raw_date[2]."/".$raw_date[1]."/".$convert_year;
              ?>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">วันเกิด</label>
                    <input type="datetime" class="form-control" id="dob" value="<?=$dob?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">เบอร์โทรศัพท์</label>
                    <input type="tel" class="form-control" id="phone" placeholder="" value="<?=$query['phone']?>">
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">Line ID</label>
                    <input type="text" class="form-control" id="line_id" placeholder="" value="<?=$query['line_id']?>">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label for="">ที่อยู่</label>
                    <textarea class="form-control" id="address" rows="2" placeholder=""><?=$query['address']?></textarea>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="">ช่องทางสมัคร</label>
                    <?php 
                      if($query['location_regis'] == 1){
                        $location = "ทอง";
                      }
                      elseif($query['location_regis'] == 2){
                        $location = "เพชร";
                      }
                      else{
                        $location = "ไม่ระบุ";
                      }
                    ?>
                    <input type="text" class="form-control" id="" value="<?=$location?>" readonly>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-4"><button class="btn btn-primary" onclick="update()">บันทึก</button></div>
              </div>
            </div>
          </div>

          <?php
              // Zone setting pic
              $path_default = "../../asset/img/default.jpg";
              $path_pic = array($path_default,$path_default);
              $dir_pic = "../../uploads/id_file/";
              $dir_pic2 = "../../uploads/bookbank/";

              if(isset($query['file']['id_path'])){
                $path_pic[0] = $dir_pic.$query['file']['id_path'];
              }

              if(isset($query['file']['bookbank_path'])){
                $path_pic[1] = $dir_pic2.$query['file']['bookbank_path'];
              }
          ?>

          <!-- โซนรูปภาพ -->
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6 pic1">
                  <div class="col-12">
                    <figure class="figure"><img style="height:150px" class="img-fluid" src="<?=$path_pic[0]?>" alt=""></figure>
                  </div>
                  <div class="col-12">
                    <div class="btn-group">
                      <button type="button" class="btn btn-secondary" onclick="select_pic('1')">เลือกรูปภาพ</button>
                      <input type="file" id="id_file" style="display:none">
                      <button type="button" class="btn btn-info" onclick="upload_file('id')">อัพโหลด</button>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="col-12">
                    <figure class="figure"><img style="height:150px" class="img-fluid" src="<?=$path_pic[1]?>" alt=""></figure>
                  </div>
                  <div class="col-12">
                    <div class="btn-group">
                      <button type="button" class="btn btn-secondary" onclick="select_pic('2')">เลือกรูปภาพ</button>
                      <input type="file" id="bookbank" style="display:none">
                      <button type="button" class="btn btn-info" onclick="upload_file('bank')">อัพโหลด</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-2">
            <div class="col-2"><button class="btn btn-warning" onclick="goback()">กลับ</button></div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include('../../template/footer.php'); ?>
<script src="js/edit.js"></script>

<script>
  $('#dob').datepicker({
    dateFormat: "dd/mm/yy"
  });
</script>

</body>
</html>