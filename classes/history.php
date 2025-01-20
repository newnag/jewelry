<?php

class History{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->cus_id = $data['cus_id'];
  }

  public function get_table(){
    try{
      $sql = $this->conn->prepare("
      SELECT gold.product_no,cate.cate_name,type.type_name,gold.weight,gold.sale_date,gold.price 
      FROM transection_gold as trans
      JOIN user ON user.id = trans.user_id
      JOIN stock_gold as gold ON gold.id = trans.item_id
      JOIN product_cate as cate ON cate.id = gold.type_product
      JOIN product_type as type ON type.id = cate.type_id
      WHERE trans.user_id = :cus_id
      ");
      $sql->bindParam(':cus_id',$this->cus_id);
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