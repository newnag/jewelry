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

<?php
  $data_type = array(
    "conn" => $conn,
    "type_name" => "",
    "cate_name" => "",
    "type_id" => "",
    "id" => ""
  );

  ///////////////////////////////////////////////////////////////
  // query data

  $type_product = new Type_product($data_type);
  $get_type = $type_product->get_type_stock("1");

  ///////////////////////////////////////////////////////////////
?>

<style>
    .btn-tb{
        margin-right: 5px;
    }

    .content-wrapper{
      height: fit-content;
    }

    .btn-submit{
      background-color: #d9a82a;
      color: #951b1e;
    }
    .btn-back{
      background-color: #d9a82a91;
      color: #951b1e;
    }

    input,select,textarea{
      border-color: #d9a82a!important;
    }

    #select_form{
      display: grid;
      grid-template-columns: repeat(4,1fr);
      row-gap: 1em;
    }
</style>

<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>พิมพ์บาร์โค้ด</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">ข้อมูลคลัง</a></li>
              <li class="breadcrumb-item active">พิมพ์บาร์โค้ด</li>
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
                <!-- <div class="col-4"><input type="text" class="form-control" id="product_no" placeholder="ใส่หมายเลขสินค้า"></div> -->
                <div class="col-4">
                  <select name="" id="type_product" class="form-control">
                    <?php
                      for($i=0;$i<count($get_type);$i++){
                        echo '
                        <option value="'.$get_type[$i]['id'].'">'.$get_type[$i]['type_name'].'</option>
                        ';
                      }
                    ?>
                  </select>
                </div>
                <div class="col-auto"><button class="btn btn-submit" onclick="search_item_barcode()"><i class="fas fa-search"></i> ค้นหา</button></div>
                <div class="col-auto"><button class="btn btn-submit" onclick="print_warehouse()"><i class="fas fa-print"></i> พิมพ์</button></div>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-12">
                <div class="form-group" id="select_form">
                    <!-- checkbox product_no -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
</div>

<form action="https://thavorn-jewelry.com/stock-gold/warehouse/barcode-print.php" id="barcode-form" method="POST">

</form>

</div>

<?php include('../../template/footer.php'); ?>

<script src="js/stock.js"></script>

</body>
</html>

