<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../functions/check-login.php');
include('../../classes/member-reward.php');

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

  .tb-action{
    width: 200px;
  }

  tbody .child .dtr-details{
    min-width: 200px;
  }

  .content-wrapper{
    min-height: 1500px!important;
  }

  .btn-edit{
    color: #fff;
    background-color: #30c0d2;
  }
  .btn-add{
    color: #fff;
    background-color: #f7a686;
  }
</style>

<?php
  $data = array(
    "conn" => $conn,
    "name" => "",
    "point" => "",
    "amount" => "",
    "detail" => "",
    "id" => ""
  );

  $stock = new Member_reward($data);
  $result = $stock->get();
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ตั้งค่าของรางวัล</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ตั้งค่าของรางวัล</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><h4>ของรางวัล</h4></div>

                    <div class="card-tools">
                        <button class="btn btn-sm btn-add" onclick="add_new()"><i class="fas fa-plus"></i> เพิ่มของรางวัล</button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-type" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="80">ลำดับ</th>
                            <th>ชื่อของรางวัล</th>
                            <th>จำนวนคะแนน</th>
                            <th>จำนวนรางวัล</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php
                            foreach($result as $key=>$data){
                              $key += 1;
                              echo '
                                <tr>
                                  <td>'.$key.'</td>
                                  <td>'.$data['name'].'</td>
                                  <td>'.$data['use_point'].'</td>
                                  <td>'.$data['amount'].'</td>
                                  <td>
                                    <div class="row">
                                      <div class="col-auto"><button type="button" class="btn btn-block btn-edit btn-cus-w" onclick="edit('.$data['id'].')">ดู/แก้ไข</button></div>
                                    </div>
                                  </td>
                                </tr>
                              ';
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

<script src="js/reward.js"></script>

<script type="text/javascript">
  $(document).ready( function () {
    setTimeout(() => {
      $('#table-type').DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });

      $('#table-cate').DataTable({
        "paging": true,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    }, 500);
  });

  function add_new(){
    location.href = "https://thavorn-jewelry.com/member/reward/add.php"
  }

  function edit(id){
    location.href = "https://thavorn-jewelry.com/member/reward/edit.php?id="+id
  }
</script>

</body>
</html>

