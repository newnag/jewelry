<?php

class Report_gold{
  function __construct($data){
    $this->conn = $data['conn'];
    $this->date1 = $data['date1'];
    $this->date2 = $data['date2'];
    $this->type_report = $data['type_report'];
  }

  public function report(){
    if($this->type_report == 1){
      $farr = array();

      try{
        $sumsql = $this->conn->prepare("SELECT COUNT(id) as total_list FROM stock_gold WHERE sale_date BETWEEN :date1 AND :date2");
        $sumsql->bindParam(':date1',$this->date1);
        $sumsql->bindParam(':date2',$this->date2);
        $sumsql->execute();
        $result_sum = $sumsql->fetch(PDO::FETCH_NAMED);

        $farr['sum'] = $result_sum;

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        $salesql = $this->conn->prepare("SELECT SUM(price) as total_sale FROM stock_gold WHERE sale_date BETWEEN :date1 AND :date2");
        $salesql->bindParam(':date1',$this->date1);
        $salesql->bindParam(':date2',$this->date2);
        $salesql->execute();
        $result_sale = $salesql->fetch(PDO::FETCH_NAMED);

        $farr['price'] = $result_sale;

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        // $sql = $this->conn->prepare("
        // SELECT stock.id,stock.product_no,stock.weight,stock.sale_date,stock.price,user.fullname 
        // FROM stock_gold as stock
        // JOIN transection_gold as trans ON trans.item_id = stock.id
        // JOIN user ON user.id = trans.user_id
        // WHERE stock.status = 2 AND sale_date BETWEEN :date1 AND :date2
        // ");
        $sql = $this->conn->prepare("
          SELECT trans.id,stock.product_no,stock.weight,stock.sale_date,trans.sum_price,user.fullname
          FROM transection_gold as trans
          JOIN stock_gold as stock ON stock.id = trans.item_id
          JOIN user ON user.id = trans.user_id
          WHERE trans.create_date BETWEEN :date1 AND :date2;
        ");
        $sql->bindParam(':date1',$this->date1);
        $sql->bindParam(':date2',$this->date2);
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          $farr['item'] = $arr;

          if(count($arr) > 0){
            return $farr;
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
    elseif($this->type_report == 2){
      $farr = array();

      try{
        $sumsql = $this->conn->prepare("SELECT COUNT(id) as total_list FROM stock_gold WHERE position = 2 AND import_date BETWEEN :date1 AND :date2");
        $sumsql->bindParam(':date1',$this->date1);
        $sumsql->bindParam(':date2',$this->date2);
        $sumsql->execute();
        $result_sum = $sumsql->fetch(PDO::FETCH_NAMED);

        $farr['sum'] = $result_sum;

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        $salesql = $this->conn->prepare("SELECT SUM(cost) as total_cost FROM stock_gold WHERE position = 2 AND import_date BETWEEN :date1 AND :date2");
        $salesql->bindParam(':date1',$this->date1);
        $salesql->bindParam(':date2',$this->date2);
        $salesql->execute();
        $result_sale = $salesql->fetch(PDO::FETCH_NAMED);

        $farr['price'] = $result_sale;

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = $this->conn->prepare("
        SELECT type.id as type_id,type.type_name,cate.id as cate_id,cate.cate_name,(SELECT COUNT(stock.type_product) FROM stock_gold as stock WHERE stock.type_product = cate.id AND stock.position = 2) as amount
        FROM product_type as type
        JOIN product_cate as cate ON cate.type_id = type.id
        WHERE type.product_type = 1
        ORDER BY type.id;
        ");
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          $farr['item'] = $arr;

          if(count($arr) > 0){
            return $farr;
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
    elseif($this->type_report == 3){
      $farr = array();

      try{
        $sumsql = $this->conn->prepare("SELECT COUNT(id) as total_list FROM stock_gold WHERE position = 1 AND import_date BETWEEN :date1 AND :date2");
        $sumsql->bindParam(':date1',$this->date1);
        $sumsql->bindParam(':date2',$this->date2);
        $sumsql->execute();
        $result_sum = $sumsql->fetch(PDO::FETCH_NAMED);

        $farr['sum'] = $result_sum;

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        $salesql = $this->conn->prepare("SELECT SUM(cost) as total_cost FROM stock_gold WHERE position = 1 AND import_date BETWEEN :date1 AND :date2");
        $salesql->bindParam(':date1',$this->date1);
        $salesql->bindParam(':date2',$this->date2);
        $salesql->execute();
        $result_sale = $salesql->fetch(PDO::FETCH_NAMED);

        $farr['price'] = $result_sale;

        /////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = $this->conn->prepare("
        SELECT type.id as type_id,type.type_name,cate.id as cate_id,cate.cate_name,(SELECT COUNT(stock.type_product) FROM stock_gold as stock WHERE stock.type_product = cate.id AND stock.position = 1) as amount
        FROM product_type as type
        JOIN product_cate as cate ON cate.type_id = type.id
        WHERE type.product_type = 1
        ORDER BY type.id;
        ");
        $sql->bindParam(':date1',$this->date1);
        $sql->bindParam(':date2',$this->date2);
        if($sql->execute()){
          $arr = array();
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr[] = $result;
          }

          $farr['item'] = $arr;

          if(count($arr) > 0){
            return $farr;
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

  public function report_sale($month){
    try{
      // $txt_param = implode(',',$data);

      $sql = $this->conn->prepare("
        SELECT trans.create_date,user.fullname,user.id_no,stock.weight,stock.net_total,stock.diff_sell_price,stock.vat_base,stock.vat,stock.vat_exclude
        FROM transection_gold as trans
        JOIN user ON trans.user_id = user.id
        JOIN stock_gold as stock ON stock.id = trans.item_id
        WHERE Month(trans.create_date) = $month
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

  public function print_report_trans() {
    try {
      $sql = $this->conn->prepare("SELECT trans.create_date, sup.name, sup.tax_id, type.type_name, cate.cate_name, stock.weight, stock.cost_price
      FROM transection_gold as trans
      JOIN stock_gold as stock ON trans.item_id = stock.id
      JOIN product_cate as cate ON stock.type_product = cate.id
      JOIN product_type as type ON cate.type_id = type.id
      JOIN supplier as sup ON stock.type_supplier = sup.name
      WHERE trans.create_date BETWEEN :date1 AND :date2 ");
      $sql->bindParam(':date1', $this->date1);
      $sql->bindParam(':date2', $this->date2);
      if ($sql->execute()) {
        $arr = array();
        while ($result = $sql->fetch(PDO::FETCH_NAMED)) {
          $arr[] = $result;
          // print_r($result);
        }
        if (count($arr) > 0) {
          return $arr;
        } else {
          return false;
        }
      } else {
        return false;
      }
      
    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }
}

?>