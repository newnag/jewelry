<?php

class Sale_gold{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->barcode = $data['barcode'];
    $this->cus_id = $data['cus_id'];
    $this->item_id = $data['item_id'];
    $this->sale_date = $data['date_sale'];
    $this->gold_price = $data['gold_price'];
    $this->wage = $data['wage'];
    $this->sum_sale = $data['sum_sale'];
    $this->diff = $data['diff'];
    $this->resale_price = $data['resale_price'];
    $this->net_vat = $data['net_vat'];
    $this->vat_base = $data['vat_base'];
    $this->vat = $data['vat'];
    $this->price_exclude = $data['price_exclude'];
  }

  public function get_table(){
    try{
      $sql = $this->conn->prepare("
      SELECT stock.*,cate.cate_name,type.type_name,pic.pic_path
      FROM stock_gold as stock
      JOIN product_cate as cate ON cate.id = stock.type_product
      JOIN product_type as type ON type.id = cate.type_id
      JOIN stock_gold_pic as pic ON pic.stock_id = stock.id
      WHERE stock.product_no = :product_no AND stock.status != 2 AND stock.position IN (1,3)
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

  public function add_sale($point,$resale_price){
    $status = 2;
    $now = date('Y-m-d H:i:s');

    try{
      $sql = $this->conn->prepare("UPDATE stock_gold SET
        sale_date = :sale_date,
        price = :price,
        wage = :wage,
        net_total = :net_total,
        resale_price = :resale_price,
        diff_sell_price = :diff_sell_price,
        vat_base = :vat_base,
        vat = :vat,
        vat_exclude = :vat_exclude,
        status = :status
      WHERE id = :id");
      $sql->bindParam(':sale_date',$this->sale_date);
      $sql->bindParam(':price',$this->gold_price);
      $sql->bindParam(':wage',$this->wage);
      $sql->bindParam(':net_total',$this->net_vat);
      $sql->bindParam(':resale_price',$this->resale_price);
      $sql->bindParam(':diff_sell_price',$this->diff);
      $sql->bindParam(':vat_base',$this->vat_base);
      $sql->bindParam(':vat',$this->vat);
      $sql->bindParam(':vat_exclude',$this->price_exclude);
      $sql->bindParam(':status',$status);
      $sql->bindParam(':id',$this->item_id);

      if($sql->execute()){
        // สร้าง transection
        $sql2 = $this->conn->prepare("INSERT INTO transection_gold (item_id, user_id, gold_price, sum_price, point_received, sell_price, create_date)
        VALUES (:item_id,:user_id,:create_date,:gold_price,:sum_price,:point_received,:sell_price)");
        $sql2->bindParam(':item_id',$this->item_id);
        $sql2->bindParam(':user_id',$this->cus_id);
        $sql2->bindParam(':gold_price',$this->gold_price);
        $sql2->bindParam(':sum_price',$this->sum_sale);
        $sql2->bindParam(':point_received',$point);
        $sql2->bindParam(':sell_price',$resale_price);
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