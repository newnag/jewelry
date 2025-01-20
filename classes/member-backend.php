<?php
include('user.php');

session_start();

class member_backend extends User{
  public function getcard_dashboard(){
      $arr_data = array();
      try{
        $sql = $this->conn->prepare("SELECT COUNT(id) FROM user WHERE MONTH(create_date) = MONTH(CURRENT_DATE()) AND status = 1");
        if($sql->execute()){
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr_data['new_member'] = $result['COUNT(id)'];
          }
        }
        else{
          $arr_data['new_member'] = 0;
        }

        /////////////////////////////////////////////////////////////////////////////////////////////

        $sql = $this->conn->prepare("SELECT COUNT(id) FROM user WHERE status = 1");
        if($sql->execute()){
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr_data['total_member'] = $result['COUNT(id)'];
          }
        }
        else{
          $arr_data['total_member'] = 0;
        }

        /////////////////////////////////////////////////////////////////////////////////////////////

        $sql = $this->conn->prepare("SELECT COUNT(id) FROM user WHERE location_regis = 1 AND status = 1;");
        if($sql->execute()){
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr_data['gold_member'] = $result['COUNT(id)'];
          }
        }
        else{
          $arr_data['gold_member'] = 0;
        }

        /////////////////////////////////////////////////////////////////////////////////////////////

        $sql = $this->conn->prepare("SELECT COUNT(id) FROM user WHERE location_regis = 2 AND status = 1;");
        if($sql->execute()){
          while($result = $sql->fetch(PDO::FETCH_NAMED)){
            $arr_data['jewelry_member'] = $result['COUNT(id)'];
          }
        }
        else{
          $arr_data['jewelry_member'] = 0;
        }

        return $arr_data;
      }
      catch(PDOException $e){
        echo "Error: " . $e->getMessage();
      }
  }

  public function get_member_graph($location_type){
    $current_month = date('m');
    $arr_data = array();

    // for($i=1;$i<=$current_month;$i++){
    //   $sql = $this->conn->prepare("SELECT COUNT(id) FROM user WHERE MONTH(create_date) = $i AND location_regis = $location_type AND status = 1");
    //   if($sql->execute()){
    //     while($result = $sql->fetch(PDO::FETCH_NAMED)){
    //       $arr_data[$i-1] = $result['COUNT(id)'];
    //     }
    //   }
    //   else{
    //     $arr_data[$i-1] = 0;
    //   }
    // }

    $sql = $this->conn->prepare("SELECT YEAR(create_date),MONTH(create_date),COUNT(create_date) FROM user WHERE location_regis = $location_type AND status = 1 GROUP BY YEAR(create_date), MONTH(create_date);");
    if($sql->execute()){
      while($result = $sql->fetch(PDO::FETCH_NAMED)){
        $arr_data[] = $result;
      }
    }

    return $arr_data;
  }
}