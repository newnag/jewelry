<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');

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
    .btn-tb{
      margin-right: 5px;
    }

    .tb-action{
      width: 200px;
    }

    tbody .child .dtr-details{
      min-width: 200px;
    }

    .main-sidebar{
        height: 1800px!important;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ประเภทสินค้า</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">ประเภทสินค้า</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><h4>ประเภท</h4></div>

                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-type"><i class="fas fa-plus"></i> เพิ่มประเภท</button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-type" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="80">ลำดับ</th>
                            <th>ชื่อประเภท</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="card-title"><h4>หมวดหมู่</h4></div>

                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-cate"><i class="fas fa-plus"></i> เพิ่มหมวดหมู่</button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-cate" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th width="80">ลำดับ</th>
                            <th>ชื่อหมวดหมู่</th>
                            <th>ชื่อประเภท</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

</div>

<div class="modal fade show" id="modal-add-type" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">เพิ่มประเภท</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="type_name">ชื่อประเภท</label>
          <input type="text" class="form-control" id="type_name" placeholder="ใส่ชื่อประเภท">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="add_type()">เพิ่ม</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade show" id="modal-edit-type" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">แก้ไขประเภท</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="type_name">ชื่อประเภท</label>
          <input type="text" class="form-control" id="type_edit_name" placeholder="ใส่ชื่อประเภท">
          <input type="hidden" id="type_edit_id">
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="update_type()">แก้ไข</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade show" id="modal-add-cate" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">เพิ่มหมวดหมู่</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="cate_name">ชื่อหมวดหมู่</label>
          <input type="text" class="form-control" id="cate_name" placeholder="ใส่ชื่อประเภท">
        </div>

        <div class="form-group">
          <label for="type_id">ชื่อประเภท</label>
          <select name="" id="type_id" class="form-control">
              
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="add_cate()">เพิ่ม</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade show" id="modal-edit-cate" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">แก้ไขหมวดหมู่</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="cate_name">ชื่อหมวดหมู่</label>
          <input type="text" class="form-control" id="cate_edit_name" placeholder="ใส่ชื่อประเภท">
          <input type="hidden" id="cate_edit_id">
        </div>

        <div class="form-group">
          <label for="type_id_cate_edit">ชื่อประเภท</label>
          <select name="" id="type_id_cate_edit" class="form-control">
              
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="update_cate()">แก้ไข</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
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

<script src="js/type.js"></script>

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
</script>

</body>
</html>

