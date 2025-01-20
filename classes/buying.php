<?php

class Buy_gold{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->po_no = $data['po_no'];
    $this->cus_id = $data['cus_id'];
    $this->datetime = $data['datetime'];
    $this->type_product = $data['type_product'];
    $this->amount = $data['amount'];
    $this->weight = $data['weight'];
    $this->detail = $data['detail'];
    $this->price_buy = $data['price_buy'];
    $this->price_sale = $data['price_sale'];
    $this->price_buy_num = $data['price_buy_num'];
    $this->price_buy_txt = $data['price_buy_txt'];
    $this->customFile = $data['customFile'];
    $this->id = $data['id'];
  }

  public function get_table(){
    try{
      $sql = $this->conn->prepare("
      SELECT stock.*,cate.cate_name,type.type_name,pic.pic_path
      FROM stock_gold as stock
      JOIN product_cate as cate ON cate.id = stock.type_product
      JOIN product_type as type ON type.id = cate.type_id
      JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
      WHERE stock.product_no = :product_no AND stock.status != 2 AND stock.position = 1
      ");
      $sql->bindParam(':product_no',$this->barcode);
      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_NAMED);

        if($result){
          return $result;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function add_buy(){
    // transform date
    $date_raw = explode('T',$this->datetime);
    $date = $date_raw[0];
    $time = $date_raw[1];
    $date_f = $date." ".$time;
    //////////////////////////////////////////////

    try{
      // upload img
      $txt_path = "";

      if($this->customFile != ""){
        $target_dir1     =   "../../../uploads/buy-gold";
        $avatar_name1    =   md5('YmdHis').'-'.$this->cus_id.'-'.date("Ymd-His").'-'.basename($this->customFile['name']);
        $target_file1    =   $target_dir1 .'/'.$avatar_name1;
        $uploadOk1       =   1;
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

        $check1 = getimagesize($this->customFile["tmp_name"]);

        if($check1 !== false) {
          $uploadOk1 = 1;
        } else {
          $uploadOk1 = 0;
        }

        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
          $uploadOk1 = 0;
        }

        if ($uploadOk1 == 1) {
          if (move_uploaded_file($this->customFile["tmp_name"], $target_file1)) {
              $txt_path = $avatar_name1;
          }
        }
      }

      if($txt_path != ""){
        $sql = $this->conn->prepare("
          INSERT INTO buying_gold(po_no,cus_id,date,type_product,amount,weight,price_buy,price_sell,detail,price_buy_num,price_buy_txt,pic_path)
          VALUES(:po_no,:cus_id,:date,:type_product,:amount,:weight,:price_buy,:price_sell,:detail,:price_buy_num,:price_buy_txt,:pic_path)
        ");
        $sql->bindParam(':po_no',$this->po_no);
        $sql->bindParam(':cus_id',$this->cus_id);
        $sql->bindParam(':date',$date_f);
        $sql->bindParam(':type_product',$this->type_product);
        $sql->bindParam(':amount',$this->amount);
        $sql->bindParam(':weight',$this->weight);
        $sql->bindParam(':price_buy',$this->price_buy);
        $sql->bindParam(':price_sell',$this->price_sell);
        $sql->bindParam(':detail',$this->detail);
        $sql->bindParam(':price_buy_num',$this->price_buy_num);
        $sql->bindParam(':price_buy_txt',$this->price_buy_txt);
        $sql->bindParam(':pic_path',$txt_path);
        if($sql->execute()){
          return true;
        }
        else{
          return false;
        }
      }          
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function search_history($txt,$date){
    try{
      $raw1 = "";
      $rawDate = explode('-',$date);
      $formatDate1 = explode('/',$rawDate[0]);
      $formatDate1 = $formatDate1[2]."-".$formatDate1[0]."-".$formatDate1[1]." 00:00:00";
      $formatDate2 = explode('/',$rawDate[1]);
      $formatDate2 = $formatDate2[2]."-".$formatDate2[0]."-".$formatDate2[1]." 23:59:59";
      
      $sql1 = $this->conn->prepare("SELECT id FROM user WHERE fullname = :txt AND status = 1");
      $sql1->bindParam(':txt',$txt);
      if($sql1->execute()){
        $raw1 = $sql1->fetch(PDO::FETCH_NAMED);

        if($raw1 == ""){
          $sql2 = $this->conn->prepare("SELECT id FROM stock_gold WHERE product_no = :txt AND status = 2");
          $sql2->bindParam(':txt',$txt);
          $sql2->execute();
          $raw1 = $sql2->fetch(PDO::FETCH_NAMED);
        }

        $sql = $this->conn->prepare("SELECT * FROM transection_gold WHERE :ftxt IN (item_id,user_id) AND create_date BETWEEN '".$formatDate1."' AND '".$formatDate2."' AND status = 1");
        $sql->bindParam(':ftxt',$raw1['id']);
        if($sql->execute()){
          $result = $sql->fetch(PDO::FETCH_NAMED);
          
          if($result){
            $arr = array();

            $sqlf = $this->conn->prepare("
              SELECT trans.create_date,user.fullname,type.type_name,trans.sum_price,trans.id
              FROM transection_gold as trans
              JOIN stock_gold as stock ON stock.id = trans.item_id
              JOIN product_cate as cate ON cate.id = stock.type_product
              JOIN product_type as type ON type.id = cate.type_id
              JOIN user ON user.id = trans.user_id
              WHERE trans.id = :trans_id;
            ");
            $sqlf->bindParam(':trans_id',$result['id']);
            if($sqlf->execute()){
              while($result1 = $sqlf->fetch(PDO::FETCH_NAMED)){
                $arr[] = $result1;
              }

              if(count($arr) > 0){
                return $arr;
              }
              else{
                return false;
              }
            }
          }
          else{
            return false;
          }
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function get_data_sale($trans_id){
    try{
      $sql = $this->conn->prepare("
        SELECT trans.*,user.*,stock.*,pic.pic_path,type.type_name,cate.cate_name
        FROM transection_gold as trans
        JOIN stock_gold as stock ON stock.id = trans.item_id
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON type.id = cate.type_id
        JOIN user ON user.id = trans.user_id
        JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
        WHERE trans.id = :trans_id;
      ");
      $sql->bindParam(':trans_id',$trans_id);
      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_NAMED);

        if($result){
          return $result;
        }
        else{
          return false;
        }
      }else{
        return false;
      }
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }
}

?>