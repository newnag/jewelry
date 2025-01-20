<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../../classes/member-reward.php');
include('../../classes/user.php');
include('../functions/check-login.php');

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
    "name" => "",
    "point" => "",
    "amount" => "",
    "detail" => "",
    "id" => ""
  );

  $data_user = array(
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

  ///////////////////////////////////////////////////////////////
  // query data

  $user_id = $_GET['id'];

  $user = new User($data_user);
  $get_user = $user->get_data();

  $history = new Member_reward($data);
  $get_data_gold = $history->get_history($user_id);

  ///////////////////////////////////////////////////////////////
?>

<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">


<style>
    .btn-tb{
      margin-right: 5px;
    }

    .tb-action{
      width: 180px;
    }

    /* .main-sidebar{
      height: 1100px!important;
    } */
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ประวัติการซื้อ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ประวัติการซื้อ</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <!-- <div class="row mt-2">
                <div class="col-md-3">
                  <div class="row px-2">
                    <label>รหัสลูกค้า: </label>
                    <p class="ml-3"><?=$get_user[0]['id_customer']?></p>
                  </div>
                </div>
              </div> -->
              <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">รหัสลูกค้า: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['id_customer']?>">
                </div>
              </div>

              <div class="row mt-2">
                <div class="col-md-3">
                  <div class="row px-2">
                    <label>ชื่อลูกค้า: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['fullname']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['fullname']?></p> -->
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="row px-2">
                    <label>เลขประจำตัว: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['id_no']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['id_no']?></p> -->
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="row px-2">
                    <label>เบอร์โทร: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['phone']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['phone']?></p> -->
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="row px-2">
                    <label>Line ID: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['line_id']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['line_id']?></p> -->
                  </div>
                </div>
              </div>
              
              <div class="row mt-2">
                <div class="col-md-3">
                  <div class="row px-2">
                    <label>วันเกิด: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['DOB']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['DOB']?></p> -->
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="row px-2">
                    <label>เพศ: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['sex']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['sex']?></p> -->
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="row px-2">
                    <label>ที่อยู่: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['address']?>">
                    <!-- <p class="ml-3"><?=$get_user[0]['address']?></p> -->
                  </div>
                </div>
              </div>

              <div class="row mt-2">
                <div class="col-md-3">
                  <div class="row px-2">
                    <label>คะแนนสะสม: </label>
                    <input type="text" class="form-control input-dis" disabled value="<?=$get_user[0]['point']?>">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card">
              <div class="card-body">
                <table id="table-history" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>วันที่</th>
                      <th>ของรางวัล</th>
                      <th>จำนวนคะแนน</th>
                      <th>จำนวนชิ้น</th>
                      <th>คำแนนคงเหลือ</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                      for($i=0;$i<count($get_data_gold);$i++){
                        echo "
                          <tr>
                            <td>".$get_data_gold[$i]['create_date']."</td>
                            <td>".$get_data_gold[$i]['reward_name']."</td>
                            <td>".$get_data_gold[$i]['point']."</td>
                            <td>".$get_data_gold[$i]['amount']."</td>
                            <td></td>
                          </tr>
                        ";
                      }

                    ?>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
  $(document).ready( function () {
    $('#table-history').DataTable({
      "paging": true,
      "lengthChange": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</body>
</html>

