<?php 

include('../../classes/auth.php') ;
include('../../config/db.php');
include('../function/check-login.php');
include('../../classes/supplier.php');

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

    .content-wrapper{
      height: fit-content;
    }
</style>

<?php
    $data = array(
        "conn" => $conn,
        "supplier_name" => "",
        "id" => ""
    );
  
    $sup = new Supplier($data);
    $get_data = $sup->get();
?>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
              <li class="breadcrumb-item active">Supplier</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><h4>Supplier</h4></div>

                    <div class="card-tools">
                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-add-type"><i class="fas fa-plus"></i> เพิ่มSupplier</button>
                    </div>
                </div>

                <div class="card-body">
                    <table id="table-type" class="table table-bordered table-hover">
                        <thead>
                          <tr>
                            <th>ชื่อ Supplier</th>
                            <th>ประเภท</th>
                            <th class="tb-action">Action</th>
                          </tr>
                        </thead>

                        <tbody>
                            <?php
                                if($get_data != ""){
                                  foreach($get_data as $data){
                                    if($data['type_supplier'] == 1){
                                      $type = "ทอง";
                                    }
                                    elseif($data['type_supplier'] == 2){
                                      $type = "กรอบพระ";
                                    }

                                    echo '
                                    <tr>
                                        <td>'.$data['name'].'</td>
                                        <td>'.$type.'</td>
                                        <td>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-6"><button type="button" class="btn btn-block bg-gradient-warning btn-cus-w" onclick="edit('.$data['id'].')" data-toggle="modal" data-target="#modal-edit-type">แก้ไข</button></div>
                                                    <div class="col-6"><button type="button" class="btn btn-block bg-gradient-danger btn-cus-w" onclick="item_delete('.$data['id'].')">ลบ</button></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    ';
                                  }
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

<div class="modal fade show" id="modal-add-type" aria-modal="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">เพิ่มsupplier</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="supplier_name">ชื่อ supplier</label>
          <input type="text" class="form-control" id="supplier_name" placeholder="ใส่ชื่อ supplier">
        </div>

        <div class="form-group">
          <label for="type_supplier">ประเภท</label>
          <select name="" id="type_supplier" class="form-control">
            <option value="1">ทอง</option>
            <option value="2">กรอบพระ</option>
          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="add()">เพิ่ม</button>
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
        <h4 class="modal-title">แก้ไขsupplier</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-add">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label for="supplier_name_edit">ชื่อ supplier</label>
            <input type="text" class="form-control" id="supplier_name_edit" placeholder="ใส่ชื่อ supplier">
            <input type="hidden" id="edit_id">
        </div>

        <div class="form-group">
          <label for="type_supplier_edit">ประเภท</label>
          <select name="" id="type_supplier_edit" class="form-control">

          </select>
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary" onclick="update()">แก้ไข</button>
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

<script src="js/supplier.js"></script>

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
    }, 500);
    
  });
</script>

</body>
</html>

