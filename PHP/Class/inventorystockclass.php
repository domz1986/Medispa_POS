<?php

  date_default_timezone_set('Asia/Singapore');

  class InventoryStockClass{

    private $stockID;
    private $stockQntyRemaining;
    private $stockQntyStockIn;
    private $stockDateStockIn;
    private $stockExpiration;
    private $stockORNumber;
    private $stockTotalCost;
    private $productID;


    public function setProductID($id){

      $this->productID = $this->clean_value($id);

    }

    public function setQntyStockIn($qnty){

      $this->stockQntyStockIn = $this->clean_value($qnty);

    }

    public function setExpirationDate($date){

      $this->stockExpiration = $this->clean_value($date);

    }

    public function setORNumber($or){

      $this->stockORNumber = $this->clean_value($or);

    }

    public function setTotalCost($cost){

      $this->stockTotalCost = $this->clean_value($cost);

    }

    public function setStockID($id){

      $this->stockID = $this->clean_value($id);

    }

    public function setStockQntyRemaining($qnty){

      $this->stockQntyRemaining = $this->clean_value($qnty);

    }


    private function generateID(){

      include("../connection.php");

      $sql = "SELECT stockID FROM tblproductstocks
              ORDER BY stockID DESC LIMIT 1";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          $hold = explode("-",$row['stockID']);
          $id = $hold[1]+1;
          $this->stockID = "offline_S-".$id;

        }

      }
      else {

        $this->stockID = "offline_S-100";

      }

    }


    public function saveStockRecord(){

      $this->generateID();

      $curdate = date("Y-m-d H:i:s");

      include("../connection.php");

      $sql = $con->prepare("INSERT INTO tblproductstocks (stockID,productID,stockQntyRemaining,
             stockQntyStockIn,stockDateStockIn,stockExpiration,stockORNumber,stockTotalCost)
            VALUES (?,?,?,?,?,?,?,?)");

      $sql->bind_param("ssddsssd",$this->stockID,$this->productID,$this->stockQntyStockIn,
                       $this->stockQntyStockIn,$curdate,$this->stockExpiration,
                       $this->stockORNumber,$this->stockTotalCost);

       if($sql->execute() == TRUE){

         $tableName = "tblproductstocks";

         $fieldValue = $this->stockID."=".$this->productID."=".$this->stockQntyStockIn."=".
                       $curdate."=".$this->stockExpiration."=".$this->stockORNumber."=".
                       $this->stockTotalCost;

         $sql_createdat = $con->prepare("INSERT INTO tbl_createdat (tableName,fieldValue)
                               VALUES (?,?)");

         $sql_createdat->bind_param("ss",$tableName,$fieldValue);
         $sql_createdat->execute();

         //$this->sync_created_stocks();

         return 1;

       }
       else {

         return 0;

       }

    }

    public function UpdateStockInformation(){

      include("../connection.php");

      $sql = $con->prepare("UPDATE tblproductstocks SET stockQntyStockIn = ?,
             stockQntyRemaining = ?, stockExpiration = ? WHERE stockID =?");

      $sql->bind_param("ddss",$this->stockQntyStockIn,$this->stockQntyRemaining,
            $this->stockExpiration,$this->stockID);

      if($sql->execute() == TRUE){

        $tableName = "tblproductstocks";

        $fieldValue = "2=".$this->stockID."=".$this->stockQntyStockIn."=".
                      $this->stockQntyRemaining."=".$this->stockExpiration;

        $sql_updatedat = $con->prepare("INSERT INTO tbl_updatedat (tableName,fieldValue)
                              VALUES (?,?)");

        $sql_updatedat->bind_param("ss",$tableName,$fieldValue);
        $sql_updatedat->execute();

        //$this->sync_created_stocks();
        //$this->sync_updated_stocks();

        return 1;

      }
      else {

        return 0;

      }

    }


    public function loadStocksToTable(){

      include("../connection.php");

      $sql = "SELECT * FROM tblproductstocks
              WHERE productID = '$this->productID'
              AND stockQntyRemaining > 0";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        $tdID = 0;
        $counter = 1;

        while($row = $result->fetch_assoc()){

          $date_format1 = new DateTime($row['stockDateStockIn']);
          $date_format2 = new DateTime($row['stockExpiration']);

          echo "<tr>";

            echo "<td class='center aligned'>".$counter."</td>";

            echo "<td>".$date_format1->format("M j, Y | h:i A")."</td>";

            echo "<td>
                    <input style='border: none;' type='text' id='sqs".$tdID."'
                    value='".$row['stockQntyStockIn']."' maxlength='20' readOnly>
                  </td>";

            echo "<td>
                    <input style='border: none;' type='text' id='sqr".$tdID."'
                    value='".$row['stockQntyRemaining']."' maxlength='20' readOnly>
                  </td>";

            echo "<td>
                    <input style='border: none;' type='date' id='sde".$tdID."'
                    value='".$row['stockExpiration']."'readOnly>
                  </td>";

            echo "<td id='es".$tdID."' width='100'>
                    <a style='cursor: pointer' onclick='editStock(\"".$row['stockID']."\",".$tdID.",this)'>Edit</a>
                  </td>";

          echo "</tr>";

          $tdID ++;
          $counter ++;

        }

      }

    }

    public function loadStockHistory($ds,$de){

      if(($ds != "") && ($de != "")){

        $srch_date = "AND ((DATE(stockDateStockIn) >= '$ds')
                      AND (DATE(stockDateStockIn) <= '$de'))";

      }
      else {

        $srch_date = "";

      }

      include("../connection.php");

      $sql = "SELECT * FROM tblproductstocks
              WHERE productID = '$this->productID'
              AND stockStatus = 1
              $srch_date
              ORDER BY stockDateStockIn DESC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        $counter = 1;

        while($row = $result->fetch_assoc()){

          $date_format1 = new DateTime($row['stockDateStockIn']);

          if($row['stockExpiration'] == "0000-00-00"){

            $date_exp = "";

          }

          else {

            $date_format2 = new DateTime($row['stockExpiration']);
            $date_exp = $date_format2->format("M j, Y");

          }

          if($row['stockTotalCost'] == 0){

            $totalcost = "";

          }

          else {

            $totalcost = "P ".number_format((float)$row['stockTotalCost'], 2, '.', ',');

          }

          echo "<tr>";

            echo "<td class='center aligned'>".$counter."</td>";
            echo "<td>".$date_format1->format("M j, Y | h:i A")."</td>";
            echo "<td>".$row['stockQntyStockIn']."</td>";
            echo "<td>".$row['stockORNumber']."</td>";
            echo "<td>".$totalcost."</td>";
            echo "<td>".$date_exp."</td>";

          echo "</tr>";

          $counter ++;

        }

      }

    }


    public function sync_created_stocks(){

      include("../connection.php");
      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sql = "SELECT * FROM tbl_createdat WHERE tableName = 'tblproductstocks'
                AND createdStatus = 1 ORDER BY createdID ASC";

        $result = $con->query($sql);

        if($result->num_rows > 0){

          while($row = $result->fetch_assoc()){

            $hold_value = explode("=",$row['fieldValue']);

            $sql_sync = $con_online->prepare("INSERT INTO tblproductstocks (stockID,productID,stockQntyRemaining,
                                  stockQntyStockIn,stockDateStockIn,stockExpiration,stockORNumber,stockTotalCost)
                                  VALUES (?,?,?,?,?,?,?,?)");

            $sql_sync->bind_param("ssddsssd",$hold_value[0],$hold_value[1],$hold_value[2],$hold_value[2],
                                             $hold_value[3],$hold_value[4],$hold_value[5],$hold_value[6]);

            if($sql_sync->execute() == TRUE){

              $this->update_sync_status($row['createdID'],"tbl_createdat","createdStatus","createdID");

            }

          }

        }

      }

    }

    public function sync_updated_stocks(){

      include("../connection.php");

      $sql = "SELECT * FROM tbl_updatedat WHERE tableName = 'tblproductstocks'
              AND updatedStatus = 1 ORDER BY updateID ASC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          $hold_value = explode("=",$row['fieldValue']);

          if($hold_value[0] == 1){

            $this->sync_updated_stocks_qnty($row['updateID'],$hold_value);

          }
          else {

            $this->sync_updated_stocks_info($row['updateID'],$hold_value);

          }

        }

      }

    }

    public function sync_updated_stocks_info($updateID,$hold_value){

      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sql_sync = $con_online->prepare("UPDATE tblproductstocks SET stockQntyStockIn = ?,
                              stockQntyRemaining = ?, stockExpiration = ? WHERE stockID = ?");

        $sql_sync->bind_param("ddss",$hold_value[2],$hold_value[3],$hold_value[4],$hold_value[1]);

        if($sql_sync->execute() == TRUE){

          $this->update_sync_status($updateID,"tbl_updatedat","updatedStatus","updateID");

        }

      }

    }

    public function sync_updated_stocks_qnty($updateID,$hold_value){

      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sql_sync = $con_online->prepare("UPDATE tblproductstocks SET stockQntyRemaining = stockQntyRemaining - ?
                                          WHERE stockID = ?");

        $sql_sync->bind_param("ds",$hold_value[2],$hold_value[1]);

        if($sql_sync->execute() == TRUE){

          $this->update_sync_status($updateID,"tbl_updatedat","updatedStatus","updateID");

        }

      }

    }


    private function update_sync_status($id,$table,$fieldStatus,$fieldID){

      include("../connection.php");

      $sql = "UPDATE $table SET $fieldStatus = 0 WHERE $fieldID = '$id'";
      $con->query($sql);

    }

    private function clean_value($value){

      $return_value = preg_replace('/[^a-zA-Z0-9\s-_\/().%+&#]/', "", strip_tags($value));

      return $return_value;

    }



  }

?>
