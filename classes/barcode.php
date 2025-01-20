<?php

class Barcode{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->txt = $data['txt'];
  }

  public function get_item_product($type,$type_product,$position){
    try{
        if($this->txt == ""){
          if($type === "gold"){
            $sql = $this->conn->prepare("
              SELECT stock.id,stock.product_no,type.type_name,stock.weight,stock.size,cate.cate_name 
              FROM stock_gold as stock
              JOIN product_cate as cate ON cate.id = stock.type_product
              JOIN product_type as type ON type.id = cate.type_id
              WHERE stock.position = :position AND stock.status = 1 AND type.id = :type_product
            ");
            $sql->bindParam(':position',$position);
            $sql->bindParam(':type_product',$type_product);
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
          elseif($type === "border"){
            $sql = $this->conn->prepare("
              SELECT stock.id,stock.product_no,type.type_name,stock.weight,stock.size FROM stock_gold as stock
              JOIN product_cate as cate ON cate.id = stock.type_product
              JOIN product_type as type ON type.id = cate.type_id
              WHERE stock.position = :position AND stock.status = 1 AND type.id = :type_product
            ");
            $sql->bindParam(':position',$position);
            $sql->bindParam(':type_product',$type_product);
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