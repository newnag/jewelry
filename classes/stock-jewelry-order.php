<?php

class Stock_jewelry_order{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->paper_no = $data['paper_no'];
    $this->type_product = $data['type_product'];
    $this->customer_id = $data['customer_id'];
    $this->customer_name = $data['customer_name'];
    $this->detail = $data['detail'];
    $this->order_date = $data['order_date'];
    $this->estimate_price = $data['estimate_price'];
    $this->deposit = $data['deposit'];
    $this->price = $data['price'];
    $this->cost = $data['cost'];
    $this->weight = $data['weight'];
    $this->size = $data['size'];
    $this->supplier_body_id = $data['supplier_body_id'];
    $this->supplier_body_name = $data['supplier_body_name'];
    $this->supplier_body_lot = $data['supplier_body_lot'];
    $this->supplier_body_weight = $data['supplier_body_weight'];
    $this->supplier_body_cost = $data['supplier_body_cost'];
    $this->supplier_body_type = $data['supplier_body_type'];
    $this->supplier_loose = $data['supplier_loose'];
    $this->id = $data['id'];
  }

  public function add(){
    try{
      $sql = $this->conn->prepare("INSERT INTO order_diamond (paper_no, type_product, customer_id, customer_name, detail, order_date, estimate_price, deposit, price, cost, weight, size, supplier_body_id, supplier_body_name, supplier_body_lot, supplier_body_weight, supplier_body_cost, supplier_body_type, supplier_loose)
      VALUES (:paper_no,:type_product,:customer_id,:customer_name,:detail,:order_date,:estimate_price,:deposit,:price,:cost,:weight,:size,:supplier_body_id,:supplier_body_name,:supplier_body_lot,:supplier_body_weight,:supplier_body_cost,:supplier_body_type,:supplier_loose)");
      $sql->bindParam(':paper_no',$this->paper_no);
      $sql->bindParam(':type_product',$this->type_product);
      $sql->bindParam(':customer_id',$this->customer_id);
      $sql->bindParam(':customer_name',$this->customer_name);
      $sql->bindParam(':detail',$this->detail);
      $sql->bindParam(':order_date',$this->order_date);
      $sql->bindParam(':estimate_price',$this->estimate_price);
      $sql->bindParam(':deposit',$this->deposit);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':cost',$this->cost);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':size',$this->size);
      $sql->bindParam(':supplier_body_id',$this->supplier_body_id);
      $sql->bindParam(':supplier_body_name',$this->supplier_body_name);
      $sql->bindParam(':supplier_body_lot',$this->supplier_body_lot);
      $sql->bindParam(':supplier_body_weight',$this->supplier_body_weight);
      $sql->bindParam(':supplier_body_cost',$this->supplier_body_cost);
      $sql->bindParam(':supplier_body_type',$this->supplier_body_type);
      $sql->bindParam(':supplier_loose',$this->supplier_loose);

      if($sql->execute()){
        $last_id = $this->conn->lastInsertId();
        $loose_item = json_decode($this->supplier_loose);
        $body_amount = 1;

        $sql2 = $this->conn->prepare("UPDATE stock_body_diamond SET
                                        amount = (SELECT stock.amount FROM stock_body_diamond as stock WHERE stock.id = :id) - :amount
                                      WHERE stock_body_diamond.id = :id
                                    ");
        $sql2->bindParam(':id',$this->supplier_body_id);
        $sql2->bindParam(':amount',$body_amount);
        $sql2->execute();

        for($i=0;$i<count($loose_item);$i++){
          $sql3 = $this->conn->prepare("UPDATE stock_loose_diamond SET
                                          amount = (SELECT stock.amount FROM stock_loose_diamond as stock WHERE stock.id = :id) - :amount
                                        WHERE stock_loose_diamond.id = :id
                                      ");
          $sql3->bindParam(':id',$loose_item[$i]->loose_id);
          $sql3->bindParam(':amount',$loose_item[$i]->amount);
          $sql3->execute();
        }

        return $last_id;
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
      $sql = $this->conn->prepare("SELECT ord.*,type.type_name FROM order_diamond as ord JOIN product_type as type ON type.id = ord.type_product ORDER BY ord.status DESC;");
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

  public function get_data_id(){
    try{
      $sql = $this->conn->prepare("
        SELECT 
          ord.*,
          user.id_no,user.id_customer,
          type.type_name
        FROM order_diamond as ord
        JOIN user ON user.id = ord.customer_id
        JOIN product_type as type ON type.id = ord.type_product
        WHERE ord.id = :id;
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

  public function upload_file($pic,$item_id){
    $id = $item_id;
    $now = date('Y-m-d H:i:s');

    if(count($pic['file'])>0){
      $txt_path = array("","","");

      for($i=0;$i<count($pic['file']);$i++){
        $target_dir1     =   "../../../uploads/stock-order-jewelry";
        $avatar_name1    =   md5('YmdHis').'-'.$id.'-'.date("Ymd-His").'-'.basename($pic['file']['file_'.$i]['name']);
        $target_file1    =   $target_dir1 .'/'.$avatar_name1;
        $uploadOk1       =   1;
        $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));

        $check1 = getimagesize($pic['file']['file_'.$i]["tmp_name"]);

        if($check1 !== false) {
          $uploadOk1 = 1;
        } else {
          $uploadOk1 = 0;
        }

        if($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" && $imageFileType1 != "gif" ) {
          $uploadOk1 = 0;
        }

        if ($uploadOk1 == 1) {
          if (move_uploaded_file($pic['file']['file_'.$i]["tmp_name"], $target_file1)) {
              $txt_path[$i] = $avatar_name1;
          }
        }
        
      }
    }

    // insert path
    $sql2 = $this->conn->prepare("INSERT INTO order_diamond_pic(order_id,path_1,path_2,path_3,create_date) 
                                  VALUES(:order_id,:path_1,:path_2,:path_3,:create_date)");
    $sql2->bindParam(':create_date',$now);
    $sql2->bindParam(':order_id',$id);
    $sql2->bindParam(':path_1',$txt_path[0]);
    $sql2->bindParam(':path_2',$txt_path[1]);
    $sql2->bindParam(':path_3',$txt_path[2]);
    if($sql2->execute()){
      return true;
    }
    else{
      return false;
    }
  }

  public function get_pic($id){
    try{
      $sql = $this->conn->prepare("SELECT * FROM order_diamond_pic WHERE order_id = :id");
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

  public function get_loose_item($rawdata){
    $data = json_decode($rawdata);
    try{
      $arr = array();

      for($i=0;$i<count($data);$i++){
        $id = $data[$i]->loose_id;

        $sql = $this->conn->prepare("SELECT * FROM stock_loose_diamond WHERE id = :id");
        $sql->bindParam(':id',$id);
        $sql->execute();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }
      }

      return $arr;
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }

  public function update($status){
    try{
      $sql = $this->conn->prepare("UPDATE order_diamond SET
        detail = :detail,
        estimate_price = :estimate_price,
        deposit = :deposit,
        price = :price,
        cost = :cost,
        size = :size,
        weight = :weight,
        status = :status
      WHERE id = :id");
      $sql->bindParam(':detail',$this->detail);
      $sql->bindParam(':size',$this->size);
      $sql->bindParam(':weight',$this->weight);
      $sql->bindParam(':cost',$this->cost);
      $sql->bindParam(':estimate_price',$this->estimate_price);
      $sql->bindParam(':deposit',$this->deposit);
      $sql->bindParam(':price',$this->price);
      $sql->bindParam(':status',$status);
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
      // select data to return stock
      $pre_sql = $this->conn->prepare("SELECT * FROM order_diamond WHERE id = :id ");
      $pre_sql->bindParam(':id',$this->id);
      $pre_sql->execute();
      $pre_result = $pre_sql->fetch(PDO::FETCH_NAMED);

      // delete data
      $sql = $this->conn->prepare("DELETE FROM order_diamond WHERE id = :id ");
      $sql->bindParam(':id',$this->id);

      if($sql->execute()){
        $sql2 = $this->conn->prepare("DELETE FROM order_diamond_pic WHERE order_id = :id ");
        $sql2->bindParam(':id',$this->id);
        $sql2->execute();
        
        $raw_loose = json_decode($pre_result['supplier_loose']);
        $pass_loop = 0;
        $body_amount = 1;

        // return amount body
        $sql_body = $this->conn->prepare("UPDATE stock_body_diamond SET
                                        amount = (SELECT stock.amount FROM stock_body_diamond as stock WHERE stock.id = :id) + :amount
                                      WHERE stock_body_diamond.id = :id
                                    ");
        $sql_body->bindParam(':id',$pre_result['supplier_body_id']);
        $sql_body->bindParam(':amount',$body_amount);
        if($sql_body->execute()){
          $pass_loop += 0;
        }
        else{
          $pass_loop += 1;
        }

        // return amount loose to stock
        for($i=0;$i<count($raw_loose);$i++){
          $sql3 = $this->conn->prepare("UPDATE stock_loose_diamond SET
                                          amount = (SELECT stock.amount FROM stock_loose_diamond as stock WHERE stock.id = :id) + :amount
                                        WHERE stock_loose_diamond.id = :id
                                      ");
          $sql3->bindParam(':id',$raw_loose[$i]->loose_id);
          $sql3->bindParam(':amount',$raw_loose[$i]->amount);
          if($sql3->execute()){
            $pass_loop += 0;
          }
          else{
            $pass_loop += 1;
          }
        }

        if($pass_loop <= 0){
          return true;
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