<?php

class Gold_rental{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->cus_id = $data['cus_sale_id'];
    $this->product_name = $data['product_name'];
    $this->price_rental = $data['price_rental'];
    $this->interest = $data['interest'];
    $this->detail = $data['detail'];
    $this->value = $data['value'];
    $this->id = $data['id'];
  }

  public function add(){
    try{
        $now = date('Y-m-d H:i:s');

        $sql = $this->conn->prepare("INSERT INTO gold_rental (user_id, price_rental, interest, value, product_name, detail, create_date)
        VALUES (:user_id,:price_rental,:interest,:value,:product_name,:detail,:create_date)");
        $sql->bindParam(':user_id',$this->cus_id);
        $sql->bindParam(':price_rental',$this->price_rental);
        $sql->bindParam(':interest',$this->interest);
        $sql->bindParam(':value',$this->value);
        $sql->bindParam(':product_name',$this->product_name);
        $sql->bindParam(':detail',$this->detail);
        $sql->bindParam(':create_date',$now);

        if($sql->execute()){
            return $this->conn->lastInsertId();
        }
        else{
          return false;
        }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function get(){
    try{
      $sql = $this->conn->prepare("
        SELECT rent.*,user.fullname,user.phone
        FROM gold_rental as rent
        JOIN user ON user.id = rent.user_id
        ORDER BY create_date DESC
        LIMIT 30;
      ");
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        if(count($arr)>0){
          return $arr;
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

  public function getdata(){
    try{
      $sql = $this->conn->prepare("
        SELECT rent.*,user.*
        FROM gold_rental as rent
        JOIN user ON user.id = rent.user_id
        WHERE rent.id = :id
      ");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        $result = $sql->fetch(PDO::FETCH_NAMED);

        if($result ){
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

  public function update(){
    try{
      $sql = $this->conn->prepare("UPDATE gold_rental SET
        price_rental = :price_rental,
        interest = :interest,
        value = :value,
        product_name = :product_name,
        detail = :detail
      WHERE id = :id");
      $sql->bindParam(':price_rental',$this->price_rental);
      $sql->bindParam(':interest',$this->interest);
      $sql->bindParam(':value',$this->value);
      $sql->bindParam(':product_name',$this->product_name);
      $sql->bindParam(':detail',$this->detail);
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        return true; 
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function upload_file($pic,$item_id){
    $suc = false;
    $id = $item_id;
    $now = date('Y-m-d H:i:s');

    if($pic != ""){
      $txt_path = "";

      $target_dir1     =   "../../../uploads/gold-rental";
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
        }
      }
    }

    // insert path
    $sql2 = $this->conn->prepare("UPDATE gold_rental SET pic_path = :pic_path WHERE id = :id");
    $sql2->bindParam(':id',$item_id);
    $sql2->bindParam(':pic_path',$txt_path);
    if($sql2->execute()){
      $suc = true;
    }

    if($suc){
      return true;
    }
    else{
      return false;
    }
    
  }

  public function delete(){
    try{
      $sql = $this->conn->prepare("DELETE FROM gold_rental WHERE id = :id ");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        return true;
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function get_rental(){
    try{
      $sql = $this->conn->prepare("
        SELECT trans.interest,user.fullname,user.phone,rent.product_name,rent.price_rental,trans.id,trans.pic_path
        FROM transection_rental as trans
        JOIN user ON user.id = trans.user_id
        JOIN gold_rental as rent ON rent.id = trans.item_id
        WHERE trans.status = 1;
      ");
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        if(count($arr)>0){
          return $arr;
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

  public function delete_trans(){
    try{
      $sql = $this->conn->prepare("UPDATE transection_rental SET status = 2 WHERE id = :id");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        return true;
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function accept_trans(){
    try{
      $sql = $this->conn->prepare("UPDATE transection_rental SET status = 3 WHERE id = :id");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        return true;
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function get_trans(){
    try{
      $sql = $this->conn->prepare("
        SELECT * FROM transection_rental WHERE item_id = :id AND status = 3
      ");
      $sql->bindParam(':id',$this->id);
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        if(count($arr)>0){
          return $arr;
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
}

?>