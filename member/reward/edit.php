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


<style>
  .btn-tb{
      margin-right: 5px;
  }

  .content-wrapper h1{
    color: #68a8a7;
  }
  .breadcrumb .breadcrumb-item a{
    color: #dc798c;
  }
  .breadcrumb .breadcrumb-item.active{
    color: #f7a686;
  }

  input,textarea{
    border-color: #68a8a7!important;
  }
  label{
    color: #68a8a7;
  }

  .btn-add{
    color: #fff;
    background-color: #f7a686;
  }
  .btn-close{
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
        "name" => "",
        "point" => "",
        "amount" => "",
        "detail" => "",
        "id" => $_GET['id']
    );

    $stock = new Member_reward($data);
    $result = $stock->get_data();
?>

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
              <li class="breadcrumb-item active">ตั้งค่าของรางวัล</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <input type="hidden" id="item_id" value="<?=$result['id']?>">

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                        <label for="">ชื่อของรางวัล</label>
                        <input type="text" class="form-control" id="name" value="<?=$result['name']?>">
                    </div>
                  </div>
                </div>
    
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">จำนวน</label>
                        <input type="number" class="form-control" id="amount" min="0" placeholder="" value="<?=$result['amount']?>">
                    </div>
                  </div>
    
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="">แต้มที่ใช้</label>
                        <input type="number" class="form-control" id="point" min="0" placeholder="" value="<?=$result['use_point']?>">
                    </div>
                  </div>
                </div>

              </div>

              <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">รายละเอียดของรางวัล</label>
                            <textarea name="" id="detail" class="form-control" cols="30" rows="4"><?=$result['desc_item']?></textarea>
                        </div>
                    </div>
                </div>

              </div>
            </div>


            <div class="row">
                <div class="col-auto"><button class="btn btn-add" onclick="update()">บันทึก</button></div>
                <div class="col-auto"><button class="btn btn-close" onclick="goback()">ปิด</button></div>

                <?php
                  if($_SESSION['role'] == 1){
                    echo '<div class="col-auto"><button class="btn btn-del" onclick="item_delete('.$result['id'].')">ลบ</button></div>';
                  }
                ?>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

</div>

<?php include('../../template/footer.php'); ?>

<script src="js/reward.js"></script>

</body>
</html>

