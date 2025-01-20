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
    $this->price_sell = $data['price_sell'];
    $this->price_buy_num = $data['price_buy_num'];
    $this->price_buy_txt = $data['price_buy_txt'];
    $this->customFile = $data['customFile'];
    $this->id = $data['id'];
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
          $sql2 = $this->conn->prepare("SELECT id FROM buying_gold WHERE po_no = :txt AND status = 1");
          $sql2->bindParam(':txt',$txt);
          $sql2->execute();
          $raw1 = $sql2->fetch(PDO::FETCH_NAMED);
        }

        $sql = $this->conn->prepare("SELECT * FROM buying_gold WHERE :ftxt IN (id,cus_id) AND date BETWEEN '".$formatDate1."' AND '".$formatDate2."' AND status = 1");
        $sql->bindParam(':ftxt',$raw1['id']);
        if($sql->execute()){
          $result = $sql->fetch(PDO::FETCH_NAMED);
          
          if($result){
            $arr = array();

            $sqlf = $this->conn->prepare("
              SELECT buy.*,user.fullname,type.type_name
              FROM buying_gold as buy
              JOIN user ON user.id = buy.cus_id
              JOIN product_type as type ON type.id = buy.type_product
              WHERE buy.id = :id AND buy.status = 1;
            ");
            $sqlf->bindParam(':id',$result['id']);
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

  public function get_data_sale(){
    try{
      $sql = $this->conn->prepare("
        SELECT user.*,buy.*,type.type_name
        FROM buying_gold as buy
        JOIN user ON user.id = buy.cus_id
        JOIN product_type as type ON type.id = buy.type_product
        WHERE buy.id = :id AND buy.status = 1;
      ");
      $sql->bindParam(':id',$this->id);
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

  public function upload_file($pic){
    if($pic != ""){
      $txt_path = "";

      $target_dir1     =   "../../../uploads/pre-upload";
      $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($pic['name']);
      $target_file1    =   $target_dir1 .'/'.$avatar_name1;
      $uploadOk1       =   1;
      $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

      $check1 = getimagesize($pic["tmp_name"]);

      if($check1 !== false) {
        $uploadOk1 = 1;
      } else {
        $uploadOk1 = 0;
      }

      if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
        $uploadOk1 = 0;
      }

      if ($uploadOk1 == 1) {
        if (move_uploaded_file($pic["tmp_name"], $target_file1)) {
            $txt_path = $avatar_name1;
            return $txt_path;
        }
      }
    }
  }
}

?>