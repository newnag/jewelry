<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../functions/check-login.php');

check_login($conn);
?>

<div class="wrapper">
<?php 
    include('../../template/header.php');
    include('../template/aside.php');
?>

<link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">


<style>
  .content-wrapper h1{
    color: #68a8a7;
  }
  .breadcrumb .breadcrumb-item a{
    color: #dc798c;
  }
  .breadcrumb .breadcrumb-item.active{
    color: #f7a686;
  }

  .btn-tb{
      margin-right: 5px;
  }

  .content-wrapper{
    height: fit-content;
  }

  @media screen and (max-width: 1365px){
    .btn-pri{
      margin-bottom: 10px;
    }

  }

  .btn-edit,.btn-add{
    color: #fff;
    background-color: #f7a686;
  }
  .btn-promo{
    color: #fff;
    background-color: #30c0d2;
  }
  .btn-del{
    color: #fff;
    background-color: #dc798c;
  }
</style>

<?php
  $data = array(
    "conn" => $conn,
    "username" => "",
    "password" => "",
    "email" => "",
    "date" => "",
    "remember" => ""
  );

  $auth = new Auth($data);
  $get_staff = $auth->get_staff();
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลผู้ดูแลระบบ</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ข้อมูลผู้ดูแลระบบ</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">

                    <div class="card-tools">
                        <button class="btn btn-sm btn-add" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus"></i> เพิ่มผู้ดูแลระบบ</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="col-12">
                      <table id="table-user" class="table table-bordered table-hover ">
                          <thead>
                            <tr>
                              <th>ลำดับ</th>
                              <th>Username</th>
                              <th>Email</th>
                              <th>ระดับ</th>
                              <th>วันที่สร้าง</th>
                              <th>Action</th>
                            </tr>
                          </thead>
  
                          <tbody>
                            <?php
                              if(count($get_staff) > 0){
                                for($i=0;$i<count($get_staff);$i++){
                                  $no = $i+1;

                                  if($get_staff[$i]['role'] != ""){
                                    if($get_staff[$i]['role'] == 1){
                                      $role_staff = "Owner";
                                    }
                                    elseif($get_staff[$i]['role'] == 2){
                                      $role_staff = "Manager";
                                    }
                                    elseif($get_staff[$i]['role'] == 3){
                                      $role_staff = "Employee";
                                    }
                                  }
                                  else{
                                    $role_staff = "ไม่มีระดับ";
                                  }

                                  echo "
                                    <tr>
                                      <td>".$no."</td>
                                      <td>".$get_staff[$i]['username']."</td>
                                      <td>".$get_staff[$i]['email']."</td>
                                      <td>".$role_staff."</td>
                                      <td>".$get_staff[$i]['create_date']."</td>
                                      <td>
                                        <div class='row'>
                                          <div class='col-auto'><button type='button' class='btn btn-block btn-edit btn-cus-w' data-toggle='modal' data-target='#modal-edit-pass' onclick='change_pass(".$get_staff[$i]['id'].")'>แก้ไขรหัสผ่าน</button></div>
                                          <div class='col-auto'><button type='button' class='btn btn-block btn-promo btn-cus-w' data-toggle='modal' data-target='#modal-edit-role' onclick='change_role(".$get_staff[$i]['id'].",".$get_staff[$i]['role'].")'>ปรับระดับ</button></div>
                                          <div class='col-auto'><button type='button' style='width:fit-content;' class='btn btn-block btn-del btn-cus-w' onclick='item_delete(".$get_staff[$i]['id'].")'>ลบ</button></div>
                                        </div>
                                      </td>
                                    </tr>
                                  ";
                                }
                              }
                            ?>
                          </tbody>
                      </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade show" id="modal-add" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">เพิ่มผู้ดูแล</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" class="form-control" id="username" placeholder="username">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="text" class="form-control" id="password">
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="email" placeholder="Email">
        </div>
        <div class="form-group">
          <label for="role">ระดับ</label>
          <select name="" id="role" class="form-control">
            <option value="1">Admin</option>
            <option value="2">Manager</option>
            <option value="3">Employee</option>
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-promo" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-add" onclick="add()">เพิ่ม</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade show" id="modal-edit-pass" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">แก้ไขรหัสผ่าน</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="password_change">Password</label>
          <input type="password" class="form-control" id="password_change" placeholder="ใส่รหัสผ่าน">
        </div>
        <div class="form-group">
          <label for="password_con">Password Confirm</label>
          <input type="password" class="form-control" id="password_con" placeholder="ใส่รหัสผ่านอีกครั้ง">
        </div>
        <input type="hidden" id="id_change_pass" value="">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-promo" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-edit" onclick="edit_pass()">แก้ไข</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade show" id="modal-edit-role" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">แก้ไขระดับ</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="change_role">ระดับ</label>
          <select name="" id="change_role" class="form-control">
            
          </select>
        </div>
        <input type="hidden" id="id_change_role" value="">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-promo" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-edit" onclick="edit_role()">แก้ไข</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>

<?php include('../../template/footer.php'); ?>

<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script src="js/staff.js"></script>

<script type="text/javascript">
  $(function () {
    setTimeout(() => {  
      $('#table-user').DataTable({
        "paging": true,
        "lengthChange": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    }, 200);
  });
</script>

</body>
</html>

