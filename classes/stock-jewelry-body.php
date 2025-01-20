<?php
/* 
## table : stock_body_diamond
## develop by nexadon
*/

class Stock_jewelry_body{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->supplier = $data['supplier'];
    $this->stock_date = $data['stock_date'];
    $this->price = $data['price'];
    $this->weight = $data['weight'];
    $this->amount = $data['amount'];
    $this->color = $data['color'];
    $this->type = $data['type'];
    $this->si = $data['si'];
    $this->weight_total = $data['weight_total'];
    $this->percent_gold = $data['percent_gold'];
    $this->id = $data['id'];
  }

  public function add($note){
    try{
      $sql = $this->conn->prepare("INSERT INTO stock_body_diamond (supplier, stock_date, price, weight, amount, type, percent_gold, percent_si, total_weight_si, gold, detail)
      VALUES (:supplier,:stock_date,:price,:weight,:amount,:type,:percent_gold,:percent_si,:total_weight_si,:gold,:detail)");
      $sql->bindParam(':supplier',$this->supplier);
      $sql->bindParam(':stock_date',$this->stock_date);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':type',$this->type);
      $sql->bindParam(':percent_gold',$this->percent_gold);
      $sql->bindParam(':percent_si',$this->si);
      $sql->bindParam(':total_weight_si',$this->weight_total);
      $sql->bindParam(':gold',$this->color);
      $sql->bindParam(':detail',$note);

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
          SELECT stock.id,stock.supplier,stock.stock_date,stock.price,stock.weight,stock.amount,type.type_name,stock.type_material,stock.percent_gold
          FROM stock_body_diamond as stock
          JOIN product_type as type ON type.id = stock.type
          WHERE stock.amount > 0
          ");
          if($sql->execute()){
            $arr = array();
            while($result = $sql->fetch(PDO::FETCH_NAMED)){
              $arr[] = $result;
            }

            if(count($arr) > 0){
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

  public function get_data(){
    try{
      $sql = $this->conn->prepare("
        SELECT *
        FROM stock_body_diamond
        WHERE id = :id
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
      }
      else{
        return false;
      }
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }

  public function get_data_type($type_id){
    try{
      $sql = $this->conn->prepare("
        SELECT id,type_name
        FROM product_type
        WHERE id = :type_id
      ");
      $sql->bindParam(':type_id',$type_id);
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

  public function update($note){
    try{
      $sql = $this->conn->prepare("UPDATE stock_body_diamond SET
        supplier = :supplier,
        stock_date = :stock_date,
        price = :price,
        weight = :weight,
        amount = :amount,
        percent_gold = :percent_gold,
        percent_si = :percent_si,
        total_weight_si = :total_weight_si,
        type = :type,
        gold = :gold,
        detail = :note
      WHERE id = :id");
      $sql->bindParam(':supplier',$this->supplier);
      $sql->bindParam(':stock_date',$this->stock_date);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':percent_gold',$this->percent_gold);
      $sql->bindParam(':percent_si',$this->si);
      $sql->bindParam(':total_weight_si',$this->weight_total);
      $sql->bindParam(':gold',$this->color);
      $sql->bindParam(':type',$this->type);
      $sql->bindParam(':note',$note);
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

  public function delete(){
    try{
      $sql = $this->conn->prepare("DELETE FROM stock_body_diamond WHERE id = :id ");
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

      $target_dir1     =   "../../../uploads/stock-body";
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
    $sql2 = $this->conn->prepare("INSERT INTO stock_body_pic(body_id,path,create_date) 
                                  VALUES(:body_id,:path,:create_date)");
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':body_id',$id);
    $sql2->bindParam(':path',$txt_path);
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

  public function get_pic($id){
    try{
      $sql = $this->conn->prepare("SELECT * FROM stock_body_pic WHERE body_id = :id");
      $sql->bindParam(':id',$id);
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
}