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

  .btn-add{
    background-color: #f7a686;
    color: #fff;
  }
  .btn-view-edit{
    background-color: #30c0d2;
    color: #fff;
  }

  .modal .modal-header h4,
  .modal .modal-header span{
    color: #dc798c;
  }
  .modal .modal-body .form-group label{
    color: #68a8a7;
  }
  .modal .modal-body .form-group input,
  .modal .modal-body .form-group select{
    border-color: #68a8a7;
  }
  .modal .modal-footer .btn-insert{
    background-color: #68a8a7;
    color: #fff;
  }

  @media screen and (max-width: 1365px){
    .btn-pri{
      margin-bottom: 10px;
    }

  }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ข้อมูลสมาชิกทั้งหมด</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ข้อมูลสมาชิก</li>
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
                        <button class="btn btn-sm btn-add" data-toggle="modal" data-target="#modal-add"><i class="fas fa-plus"></i> เพิ่มข้อมูลสมาชิก</button>
                        <button class="btn btn-sm btn-info" onclick="export_user()"><i class="fas fa-plus"></i> ส่งออกข้อมูล</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="col-12">
                      <table id="table-user" class="table table-bordered table-hover ">
                          <thead>
                            <tr>
                              <th>รหัสสมาชิก</th>
                              <th>ชื่อ-สกุล</th>
                              <th>เบอร์โทร</th>
                              <th>Action</th>
                            </tr>
                          </thead>
  
                          <tbody></tbody>
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
        <h4 class="modal-title">เพิ่มสมาชิก</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="subject_name">ชื่อ-นามสกุล</label>
          <input type="text" class="form-control" id="fullname" placeholder="ใส่ชื่อ-นามสกุล">
        </div>
        <div class="form-group">
          <label for="sex">เพศ</label>
          <select class="form-control" id="sex">
            <option value="">เลือกเพศ</option>
            <option value="ชาย">ชาย</option>
            <option value="หญิง">หญิง</option>
          </select>
        </div>
        <div class="form-group">
          <label for="dob">วันเกิด</label>
          <input type="text" class="form-control" id="dob" placeholder="dd/mm/yyyy">
        </div>
        <div class="form-group">
          <label for="phone">เบอร์โทรศัพท์</label>
          <input type="tel" class="form-control" id="phone" placeholder="ใส่เบอร์โทรศัพท์">
        </div>
        <div class="form-group">
          <label for="address">ที่อยู่</label>
          <textarea class="form-control" rows="2" placeholder="" id="address"></textarea>
        </div>
        <div class="form-group">
          <label for="id_no">เลขบัตรประชาชน</label>
          <input type="text" class="form-control" id="id_no" placeholder="ใส่เลขบัตรประชาชน">
        </div>
        <div class="form-group">
          <label for="line_id">ID LINE</label>
          <input type="text" class="form-control" id="line_id" placeholder="ใส่ ID Line">
        </div>
        <div class="form-group">
          <label for="id_file">รูปบัตรประชาชน</label>
          <input type="file" class="form-control" id="id_file" >
        </div>
        <!-- <div class="form-group">
          <label for="bookbank">รูปบัญชีธนาคาร</label>
          <input type="file" class="form-control" id="bookbank" >
        </div> -->
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-insert" onclick="add()">เพิ่ม</button>
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

<script src="../../plugins/daterangepicker/daterangepicker.js"></script>

<script lang="javascript" src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>

<script src="js/user.js?v=<?=date('Ymdhis')?>"></script>

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

