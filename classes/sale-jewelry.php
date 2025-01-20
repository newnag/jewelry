<?php

class Sale_jewelry{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->barcode = $data['barcode'];
    $this->cus_id = $data['cus_id'];
    $this->item_id = $data['item_id'];
    $this->sale_date = $data['date_sale'];
    $this->sale_price = $data['sale_price'];
    $this->sell_price = $data['sell_price'];
    $this->point_received = $data['point_received'];
  }

  public function get_table(){
    try{
      $sql = $this->conn->prepare("
        SELECT stock.*,cate.cate_name,type.type_name,pic.path_1
        FROM stock_product_diamond as stock
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON cate.type_id = type.id
        JOIN stock_product_diamond_pic as pic ON pic.product_id = stock.id
        WHERE stock.product_no = :product_no;
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

  public function add_sale(){
    $status = 2;
    $now = date('Y-m-d H:i:s');

    try{
      $pre_sql = $this->conn->prepare("SELECT id FROM stock_product_diamond WHERE id = :product_id");
      $pre_sql->bindParam(':product_id',$this->item_id);
      $pre_sql->execute();
      $result_pre = $pre_sql->fetch(PDO::FETCH_NAMED);
      if($result_pre != ""){
        $sql = $this->conn->prepare("UPDATE stock_product_diamond SET
          sale_date = :sale_date,
          price_sale = :price_sale,
          status_product = :status
        WHERE id = :id");
      }
      else{
        $sql = $this->conn->prepare("UPDATE stock_product_diamond_import SET
          sale_date = :sale_date,
          price = :price_sale,
          status = :status
        WHERE id = :id");
      }

      // $sql = $this->conn->prepare("UPDATE stock_product_diamond SET
      //   sale_date = :sale_date,
      //   price_sale = :price_sale,
      //   status = :status
      // WHERE id = :id");
      $sql->bindParam(':sale_date',$this->sale_date);
      $sql->bindParam(':price_sale',$this->sale_price);
      $sql->bindParam(':status',$status);
      $sql->bindParam(':id',$this->item_id);

      if($sql->execute()){
        // สร้าง transection
        $sql2 = $this->conn->prepare("INSERT INTO transection_jewelry (product_id, customer_id, sale_price, sell_price, point_received, create_date)
        VALUES (:product_id,:customer_id,:sale_price,:sell_price,:point_received,:create_date)");
        $sql2->bindParam(':product_id',$this->item_id);
        $sql2->bindParam(':customer_id',$this->cus_id);
        $sql2->bindParam(':sale_price',$this->sale_price);
        $sql2->bindParam(':sell_price',$this->sell_price);
        $sql2->bindParam(':point_received',$this->point_received);
        $sql2->bindParam(':create_date',$now);

        if($sql2->execute()){
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

  public function search_history($txt,$date){
    try{
      $raw1 = "";
      $rawDate = explode('-',$date);
      $formatDate1 = explode('/',$rawDate[0]);
      $formatDate1 = $formatDate1[2]."-".$formatDate1[0]."-".$formatDate1[1]." 00:00:00";
      $formatDate2 = explode('/',$rawDate[1]);
      $formatDate2 = $formatDate2[2]."-".$formatDate2[0]."-".$formatDate2[1]." 23:59:59";

      if($txt != ""){
        $sql1 = $this->conn->prepare("SELECT id FROM user WHERE phone = :txt AND status = 1");
        $sql1->bindParam(':txt',$txt);
        if($sql1->execute()){
          $raw1 = $sql1->fetch(PDO::FETCH_NAMED);
  
          if($raw1 == ""){
            $sql2 = $this->conn->prepare("SELECT id FROM stock_product_diamond WHERE product_no = :txt AND status = 2");
            $sql2->bindParam(':txt',$txt);
            $sql2->execute();
            $raw1 = $sql2->fetch(PDO::FETCH_NAMED);
          }
  
          $sql = $this->conn->prepare("SELECT * FROM transection_jewelry WHERE :ftxt IN (product_id,customer_id) AND create_date BETWEEN '".$formatDate1."' AND '".$formatDate2."' AND status = 1");
          $sql->bindParam(':ftxt',$raw1['id']);
          if($sql->execute()){
            while($pre_re = $sql->fetch(PDO::FETCH_NAMED)){
              $result[] =  $pre_re;
            }
            if($result){
              // print_r($result);
              $arr = array();
  
              for($i=0;$i<count($result);$i++){
                $sqlf = $this->conn->prepare("
                  SELECT trans.create_date,user.fullname,type.type_name,trans.sale_price,trans.id,stock.product_name
                  FROM transection_jewelry as trans
                  JOIN stock_product_diamond as stock ON stock.id = trans.product_id
                  JOIN product_cate as cate ON cate.id = stock.type_product
                  JOIN product_type as type ON type.id = cate.type_id
                  JOIN user ON user.id = trans.customer_id
                  WHERE trans.id = :trans_id;
                ");
                $sqlf->bindParam(':trans_id',$result[$i]['id']);
                if($sqlf->execute()){
                  while($result1 = $sqlf->fetch(PDO::FETCH_NAMED)){
                    $arr[] = $result1;
                  }
                }
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
          else{
            return false;
          }
        }
        else{
          return false;
        }
      }
      else{
        $sql = $this->conn->prepare("SELECT * FROM transection_jewelry WHERE create_date BETWEEN '".$formatDate1."' AND '".$formatDate2."' AND status = 1");
          if($sql->execute()){
            while($pre_re = $sql->fetch(PDO::FETCH_NAMED)){
              $result[] =  $pre_re;
            }
            if($result){
              // print_r($result);
              $arr = array();
  
              for($i=0;$i<count($result);$i++){
                $sqlf = $this->conn->prepare("
                  SELECT trans.create_date,user.fullname,type.type_name,trans.sale_price,trans.id,stock.product_name
                  FROM transection_jewelry as trans
                  JOIN stock_product_diamond as stock ON stock.id = trans.product_id
                  JOIN product_cate as cate ON cate.id = stock.type_product
                  JOIN product_type as type ON type.id = cate.type_id
                  JOIN user ON user.id = trans.customer_id
                  WHERE trans.id = :trans_id;
                ");
                $sqlf->bindParam(':trans_id',$result[$i]['id']);
                if($sqlf->execute()){
                  while($result1 = $sqlf->fetch(PDO::FETCH_NAMED)){
                    $arr[] = $result1;
                  }
                }
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
          else{
            return false;
          }
      }
      
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
  }

  public function get_data_sale($trans_id){
    try{
      $sql = $this->conn->prepare("
        SELECT trans.*,user.*,stock.*,pic.path_1,type.type_name,cate.cate_name
        FROM transection_jewelry as trans
        JOIN stock_product_diamond as stock ON stock.id = trans.product_id
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON type.id = cate.type_id
        JOIN user ON user.id = trans.customer_id
        JOIN stock_product_diamond_pic as pic ON pic.product_id = stock.id
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

  public function get_dashboard(){
    $farr = array();

    try{
      // Get number stock
      $sql_stock= $this->conn->prepare("SELECT COUNT(id) FROM stock_product_diamond WHERE status_product = 1;");
      $sql_stock->execute();
      $result_stock = $sql_stock->fetch(PDO::FETCH_NAMED);
      $farr['order_stock'] = $result_stock['COUNT(id)'];

      // Get number order total
      $sql_order_total = $this->conn->prepare("SELECT COUNT(id) FROM order_diamond;");
      $sql_order_total->execute();
      $result_order_total = $sql_order_total->fetch(PDO::FETCH_NAMED);
      $farr['order_total'] = $result_order_total['COUNT(id)'];

      // Get number order outstanding
      $sql_order_outstand = $this->conn->prepare("SELECT COUNT(id) FROM order_diamond WHERE status = 1");
      $sql_order_outstand->execute();
      $result_order_outstand = $sql_order_outstand->fetch(PDO::FETCH_NAMED);
      $farr['order_outstand'] = $result_order_outstand['COUNT(id)'];

      // Get number sale
      $sql_sale = $this->conn->prepare("SELECT COUNT(id) FROM transection_jewelry WHERE status = 1");
      $sql_sale->execute();
      $result_sale = $sql_sale->fetch(PDO::FETCH_NAMED);
      $farr['sale'] = $result_sale['COUNT(id)'];   

      return $farr;
    }
    catch(PDOException $e){
      echo "Error: " . $e->getMessage();
    }
  }

  public function get_sale_dashboard(){
    try{
      $sql = $this->conn->prepare("
        SELECT trans.*,user.*,stock.*,pic.path_1,type.type_name,cate.cate_name
        FROM transection_jewelry as trans
        JOIN stock_product_diamond as stock ON stock.id = trans.product_id
        JOIN product_cate as cate ON cate.id = stock.type_product
        JOIN product_type as type ON type.id = cate.type_id
        JOIN user ON user.id = trans.customer_id
        JOIN stock_product_diamond_pic as pic ON pic.product_id = stock.id
        ORDER BY trans.create_date DESC
        LIMIT 10;
      ");
      if($sql->execute()){
        $arr = array();
        while($result = $sql->fetch(PDO::FETCH_NAMED)){
          $arr[] = $result;
        }

        if($arr){
          return $arr;
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

  public function disable_sale(){
    try{
      $status= 2;
      $item_status = 1;

      $sql = $this->conn->prepare("
        UPDATE transection_jewelry SET
          status = :status
        WHERE id = :id;
      ");
      $sql->bindParam(':status',$status);
      $sql->bindParam(':id',$this->item_id);
      if($sql->execute()){
        $sql1 = $this->conn->prepare("
          UPDATE stock_product_diamond SET
            status_product = :item_status
          WHERE id = :item_id;
        ");
        $sql1->bindParam(':item_status',$item_status);
        $sql1->bindParam(':item_id',$this->barcode);
        if($sql1->execute()){
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

?>