<?php
/* 
## table : stock_body_diamond
## develop by nexadon
*/

class Report_jewelry{
  function __construct($data){
    $this->conn = $data['conn'];
  }

  public function get_body(){
      try{
          $sql = $this->conn->prepare("
          SELECT stock.id,stock.supplier,stock.stock_date,stock.price,stock.weight,stock.amount,type.type_name,stock.type_material,stock.percent_gold
          FROM stock_body_diamond as stock
          JOIN product_type as type ON type.id = stock.type
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

  public function get_product(){
    try{
        $sql = $this->conn->prepare("
        SELECT stock.*,dis.loose_diamond,dis.body_id
        FROM stock_product_diamond as stock
        JOIN diamond_assembly as dis ON dis.product_id = stock.id
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

  public function get_body_pic($id){
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

  public function get_product_pic($id){
    try{
      $sql = $this->conn->prepare("SELECT * FROM stock_product_diamond_pic WHERE product_id = :id");
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

  public function get_loose($data){
    try{
      $loose_id_arr = array();
      for($i=0;$i<count($data);$i++){
        $loose_id_arr[] = $data[$i]->loose_id;
      }

      $sql = $this->conn->prepare("SELECT diamond_shape FROM stock_loose_diamond WHERE id IN (".implode(", ", array_map('intval', $loose_id_arr)).");");
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        for($i=0;$i<count($data);$i++){
          $arr[$i]['weight'] = $data[$i]->weight;
          $arr[$i]['amount'] = $data[$i]->amount;
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

  public function get_body_product($id){
    try{
        $sql = $this->conn->prepare("
        SELECT * FROM stock_body_diamond WHERE id = :id
        ");
        $sql->bindParam(':id',$id);
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

  public function report_sale($date1,$date2){
    try{
      

      $sql = $this->conn->prepare("
      SELECT trans.*,user.fullname,stock.product_no,stock.product_name,pic.path_1
      FROM transection_jewelry as trans
      JOIN stock_product_diamond as stock ON stock.id = trans.product_id
      JOIN user ON user.id = trans.customer_id
      JOIN stock_product_diamond_pic as pic ON pic.product_id = stock.id
      WHERE trans.create_date BETWEEN :date1 AND :date2 
      ");
      $sql->bindParam(':date1',$date1);
      $sql->bindParam(':date2',$date2);

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