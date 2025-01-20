<?php

class Stock_jewelry_loose{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->supplier = $data['supplier'];
    $this->lot_supplier = $data['supplier_lot'];
    $this->stock_date = $data['stock_date'];
    $this->price = $data['price'];
    $this->weight = $data['weight'];
    $this->amount = $data['amount'];
    $this->total_weight = $data['weight_total'];
    $this->size = $data['size'];
    $this->color = $data['color'];
    $this->clarity = $data['clarity'];
    $this->proportion_cut = $data['proportion_cut'];
    $this->symmetry_cut = $data['symmetry_cut'];
    $this->polish_cut = $data['polish_cut'];
    $this->diamond_shape = $data['diamond_shape'];
    $this->certificate = $data['certificate'];
    $this->name_certificate = $data['name_certificate'];
    $this->id = $data['id'];
  }

  public function add($other,$fluorescent){
    try{
      $sql = $this->conn->prepare("INSERT INTO stock_loose_diamond (supplier, lot_supplier, stock_date, price, weight, total_weight, color, size, other, clarity, proportion_cut, symmetry_cut, polish_cut, fluorescent, amount, diamond_shape, certificate ,name_certificate)
      VALUES (:supplier,:lot_supplier,:stock_date,:price,:weight,:total_weight,:color,:size,:other,:clarity,:proportion_cut,:symmetry_cut,:polish_cut,:fluorescent,:amount,:diamond_shape,:certificate,:name_certificate)");
      $sql->bindParam(':supplier',$this->supplier);
      $sql->bindParam(':lot_supplier',$this->lot_supplier);
      $sql->bindParam(':stock_date',$this->stock_date);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':total_weight',$this->total_weight);
      $sql->bindParam(':color',$this->color);
      $sql->bindParam(':size',$this->size);
      $sql->bindParam(':other',$other);
      $sql->bindParam(':clarity',$this->clarity);
      $sql->bindParam(':proportion_cut',$this->proportion_cut);
      $sql->bindParam(':symmetry_cut',$this->symmetry_cut);
      $sql->bindParam(':polish_cut',$this->polish_cut);
      $sql->bindParam(':fluorescent',$fluorescent);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':diamond_shape',$this->diamond_shape);
      $sql->bindParam(':certificate',$this->certificate);
      $sql->bindParam(':name_certificate',$this->name_certificate);

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
          $sql = $this->conn->prepare("SELECT * FROM stock_loose_diamond");
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
        FROM stock_loose_diamond
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

  public function update($other,$fluorescent){
    try{
      $sql = $this->conn->prepare("UPDATE stock_loose_diamond SET
        supplier = :supplier,
        lot_supplier = :lot_supplier,
        stock_date = :stock_date,
        price = :price,
        weight = :weight,
        amount = :amount,
        total_weight = :total_weight,
        color = :color,
        size = :size,
        other = :other,
        clarity = :clarity,
        proportion_cut = :proportion_cut,
        symmetry_cut = :symmetry_cut,
        polish_cut = :polish_cut,
        fluorescent = :fluorescent,
        diamond_shape = :diamond_shape,
        certificate = :certificate,
        name_certificate = :name_certificate
      WHERE id = :id");
      $sql->bindParam(':supplier',$this->supplier);
      $sql->bindParam(':lot_supplier',$this->lot_supplier);
      $sql->bindParam(':stock_date',$this->stock_date);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':amount',$this->amount);
      $sql->bindParam(':total_weight',$this->total_weight);
      $sql->bindParam(':color',$this->color);
      $sql->bindParam(':size',$this->size);
      $sql->bindParam(':other',$other);
      $sql->bindParam(':clarity',$this->clarity);
      $sql->bindParam(':proportion_cut',$this->proportion_cut);
      $sql->bindParam(':symmetry_cut',$this->symmetry_cut);
      $sql->bindParam(':polish_cut',$this->polish_cut);
      $sql->bindParam(':diamond_shape',$this->diamond_shape);
      $sql->bindParam(':fluorescent',$fluorescent);
      $sql->bindParam(':certificate',$this->certificate);
      $sql->bindParam(':name_certificate',$this->name_certificate);
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
      $sql = $this->conn->prepare("DELETE FROM stock_loose_diamond WHERE id = :id ");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        $sql2 = $this->conn->prepare("DELETE FROM cer_loose_diamond WHERE loose_id = :id ");
        $sql2->bindParam(':id',$this->id);
        $sql2->execute();
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

      $target_dir1     =   "../../../uploads/loose-cer";
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
    $sql2 = $this->conn->prepare("INSERT INTO cer_loose_diamond(loose_id,file_part,create_date) 
                                  VALUES(:loose_id,:file_part,:create_date)");
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':loose_id',$id);
    $sql2->bindParam(':file_part',$txt_path);
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
      $sql = $this->conn->prepare("SELECT * FROM cer_loose_diamond WHERE loose_id = :id");
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

  public function update_file($pic,$id){
    $suc = false;
    $now = date('Y-m-d H:i:s');

    if($pic != ""){
      $txt_path = "";

      $target_dir1     =   "../../../uploads/loose-cer";
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

    // insupdateert path
    $sql2 = $this->conn->prepare("UPDATE cer_loose_diamond SET
                                    file_part = :file_part,
                                    create_date = :create_date
                                  WHERE loose_id = :loose_id");
    $sql2->bindParam(':file_part',$txt_path);
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':loose_id',$id);
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

  public function get_modal(){
    try{
      $sql = $this->conn->prepare("SELECT * FROM stock_loose_diamond WHERE amount > 0");
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
}