<?php

  date_default_timezone_set('Asia/Singapore');

  class InventoryClass{

    private $productID;
    private $productName;
    private $productCategory;
    private $productUnit;
    private $productPricePerUnit;
    private $productQntyPerUnit;
    private $productCompany;
    private $productPhoto = "noimage.jpg";

    private $alertType;
    private $alertQuantity;

    public function setProductName($name){

      $this->productName = $this->clean_value($name);

    }

    public function setProductCategory($category){

      $this->productCategory = $this->clean_value($category);

    }

    public function setProductUnit($unit){

      $this->productUnit = $this->clean_value($unit);

    }

    public function setProductPricePerUnit($priceperunit){

      $this->productPricePerUnit = $this->clean_value($priceperunit);

    }

    public function setProductQntyPerUnit($qntyperunit){

      $this->productQntyPerUnit = $this->clean_value($qntyperunit);

    }

    public function setProductCompany($company){

      $this->productCompany = $this->clean_value($company);

    }

    public function setProductPhoto($file_name){

      $this->productPhoto = $this->clean_value($file_name);

    }

    public function setAlertType($type){

      $this->alertType = $type;

    }

    public function setAlertQuantity($qnty){

      $this->alertQuantity = $qnty;

    }


    public function setProductID($productid){

      $this->productID = $this->clean_value($productid);

    }


    public function getProductID(){

      return $this->productID;

    }

    public function getAllProductName(){

      include("../connection.php");

      $productnamelist = array();

      $sql = "SELECT productName
              FROM tblproduct
              WHERE productStatus = 1
              ORDER BY productName ASC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          array_push($productnamelist,$row['productName']);

        }

      }

      return $productnamelist;

    }

    public function getProductInfo(){

      $productinfo = "";

      include("../connection.php");

      $sql = "SELECT *,productID AS ID,
              (SELECT SUM(stockQntyRemaining)
               FROM tblproductstocks
               WHERE productID = ID
               AND stockQntyRemaining > 0) AS Qnty
              FROM tblproduct
              WHERE productID = '$this->productID'";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          if($row['Qnty'] == ""){

            $qnty = 0;


          }
          else {

            $qnty = $row['Qnty'];

          }

          $productinfo = $row['productName']."=".$row['productCategory']."=".$row['productUnit'].
                "=".$row['productPricePerUnit']."=".$row['productQntyPerUnit'].
                "=".$row['productCompany']."=".$row['productPhoto']."=".$qnty.
                "=".$row['productAlertStatus']."=".$row['productAlertQuantity'];

        }

      }

      return $productinfo;

    }


    public function checkProductName(){

      include("../connection.php");

      $sql = "SELECT productID FROM tblproduct
              WHERE UCASE(productName) = UCASE('$this->productName')
              AND productStatus = 1";

      $result = $con->query($sql);

      return $result->num_rows;

    }

    private function generateID(){

      include("../connection.php");

      $sql = "SELECT productID FROM tblproduct
              ORDER BY productID DESC LIMIT 1";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          $hold = explode("-",$row['productID']);
          $id = $hold[1]+1;
          $this->productID = "offline_P-".$id;

        }

      }
      else {

        $this->productID = "offline_P-100";

      }

    }


    public function saveProductToInventory($check){

      if($this->checkProductName() > 0){

        if($check == 0){

          return 2;

        }

      }

      $this->generateID();

      include("../connection.php");

      $sql = $con->prepare("INSERT INTO tblproduct (productID,productName,productCategory,productUnit,
                            productQntyPerUnit,productPricePerUnit,productCompany,productPhoto,
                            productAlertStatus,productAlertQuantity) VALUES (?,?,?,?,?,?,?,?,?,?)");

      $sql->bind_param("ssssddssii",$this->productID,$this->productName,$this->productCategory,
                        $this->productUnit,$this->productQntyPerUnit,$this->productPricePerUnit,
                        $this->productCompany,$this->productPhoto,$this->alertType,$this->alertQuantity);

      if($sql->execute() == TRUE){

        $tableName = "tblproduct";

        $fieldValue = $this->productID."=".$this->productName."=".$this->productCategory."=".
                      $this->productUnit."=".$this->productQntyPerUnit."=".$this->productPricePerUnit."=".
                      $this->productCompany."=".$this->productPhoto."=".$this->alertType."=".$this->alertQuantity;

        $sql_createdat = $con->prepare("INSERT INTO tbl_createdat (tableName,fieldValue)
                              VALUES (?,?)");

        $sql_createdat->bind_param("ss",$tableName,$fieldValue);
        $sql_createdat->execute();

        //$this->sync_created_product();

        return 1;

      }else {

        return 0;

      }

    }

    public function updateProductInfo(){

      $check = "";

      include("../connection.php");

      $sql = $con->prepare("UPDATE tblproduct SET productName = ?, productCategory = ?,
              productUnit = ?, productQntyPerUnit = ?, productPricePerUnit = ?,
              productCompany = ?, productPhoto = CASE WHEN ? LIKE '$check'
              THEN productPhoto ELSE ? END, productAlertStatus = ?, productAlertQuantity = ?
              WHERE productID = ?");

      $sql->bind_param("sssddsssiis",$this->productName,$this->productCategory,$this->productUnit,
                        $this->productQntyPerUnit,$this->productPricePerUnit,$this->productCompany,
                        $this->productPhoto,$this->productPhoto,$this->alertType,$this->alertQuantity,
                        $this->productID);


      if($sql->execute() == TRUE){

        $tableName = "tblproduct";

        $fieldValue = $this->productID."=".$this->productName."=".$this->productCategory."=".
                      $this->productUnit."=".$this->productQntyPerUnit."=".$this->productPricePerUnit."=".
                      $this->productCompany."=".$this->productPhoto."=".
                      $this->alertType."=".$this->alertQuantity;

        $sql_updatedat = $con->prepare("INSERT INTO tbl_updatedat (tableName,fieldValue)
                              VALUES (?,?)");

        $sql_updatedat->bind_param("ss",$tableName,$fieldValue);
        $sql_updatedat->execute();

        //$this->sync_created_product();
        //$this->sync_updated_product();

        return 1;

      }else {

        return 0;

      }

    }

    public function deleteProduct(){

      $status = 0;

      include("../connection.php");

      $sql = $con->prepare("UPDATE tblproduct SET productStatus = ?
              WHERE productID = ?");

      $sql->bind_param("is",$status,$this->productID);

      if($sql->execute() == TRUE){

        $tableName = "tblproduct";

        $fieldValue = $this->productID;

        $sql_deletedat = $con->prepare("INSERT INTO tbl_deletedat (tableName,fieldValue)
                              VALUES (?,?)");

        $sql_deletedat->bind_param("ss",$tableName,$fieldValue);
        $sql_deletedat->execute();

        //$this->sync_created_product();
        //$this->sync_updated_product();
        //$this->sync_deleted_product();

        return 1;

      }else {

        return 0;

      }

    }


    public function loadProductsToDropBox(){

      include("../connection.php");

      $sql = "SELECT productID, productName, productCategory
              FROM tblproduct WHERE productStatus = 1
              ORDER BY productName ASC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          echo "<div class='item' data-value=\"".$row['productID']."\">".
                $row['productName']." - ". $row['productCategory'] ."</div>";

        }

      }

      $con->close();

    }

    public function loadProductListToCards($srch){

      $search_value = $this->clean_value($srch);

      include("../connection.php");

      $sql = "SELECT productCategory,productPhoto,productName,productPricePerUnit,
              productUnit,productID AS ID,
              (SELECT SUM(stockQntyRemaining)
               FROM tblproductstocks
               WHERE productID = ID
               AND stockQntyRemaining > 0) AS Qnty
              FROM tblproduct
              WHERE productStatus = 1
              AND (productName LIKE '%$search_value%'
              OR productCategory LIKE '%$search_value%')
              ORDER BY productName ASC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        while($row = $result->fetch_assoc()){

          if($row['Qnty'] == ""){

            $qnty = 0;

          }
          else {

            $qnty = $row['Qnty'];

          }

          echo '<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">';
          echo '<div class="card-small">';
          echo '<div class="containerconcard">';

          echo '<div class="card-small-image">';
          echo "<img  src='../UploadedProductPhoto/".$row['productPhoto']."' alt='Error'>";
          echo '</div>';

          echo '<span class="icon pull-right" style="cursor:pointer;">';
          echo '<input class="mini ui gray button invent1" type="submit" name="submit" value="Add Transaction" onclick="addCurrenttable(\''.$row['ID'].'\',\''.$row['productName'].'\','.$qnty.',\''.$row['productPhoto'].'\',\''.$row['productCategory'].'\','.$row['productPricePerUnit'].')"></i>';
          echo '</span>';

          echo '<div class="card-small-content"><br><br>';
          echo '<h5 style="cursor:pointer;">'
                                        .$row['productName'].'</h5>';
          echo '<h4>Quantity: '.$qnty.'</h4>';
          echo '<div class="card-small-price">P'.$row['productPricePerUnit'].' /
                                                   '.$row['productUnit'].'</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
          echo '</div>';

        }

      }

    }

    public function loadProductLowOnStocks(){

      include("../connection.php");

      $sql = "SELECT *, SUM(stockQntyRemaining) AS RemainingStock FROM tblproduct
              INNER JOIN tblproductstocks ON tblproduct.productID = tblproductstocks.productID
              WHERE productStatus = 1
              AND productAlertStatus = 1
              GROUP BY tblproductstocks.productID
              HAVING SUM(stockQntyRemaining) <= productAlertQuantity
              ORDER BY productCompany,productName ASC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        $counter = 1;

        while($row = $result->fetch_assoc()){

          echo $row['RemainingStock'];

          echo "<tr>";

            echo "<td>".$counter."</td>";
            echo "<td>".$row['productCompany']."</td>";
            echo "<td>".$row['productName']."</td>";
            echo "<td>".$row['productCategory']."</td>";
            echo "<td>P ".number_format((float)$price, 2, '.', ',')."</td>";
            echo "<td>".$row['RemainingStock']."</td>";

          echo "</tr>";

          $counter ++;

        }

      }

    }

    public function loadProductsToPrint(){

      include("../connection.php");

      $sql = "SELECT *, productID as ID,
              (SELECT SUM(stockQntyRemaining) FROM tblproductstocks WHERE productID = ID) AS RemainingStock
              FROM tblproduct
              WHERE productStatus = 1
              ORDER BY productCompany,productName ASC";

      $result = $con->query($sql);

      if($result->num_rows > 0){

        $counter = 1;

        while($row = $result->fetch_assoc()){

          $price = $row['productPricePerUnit'] * $row['productQntyPerUnit'];

          echo "<tr>";

            echo "<td>".$counter."</td>";
            echo "<td>".$row['productCompany']."</td>";
            echo "<td>".$row['productName']."</td>";
            echo "<td>".$row['productCategory']."</td>";
            echo "<td>P ".number_format((float)$price, 2, '.', ',')."</td>";
            echo "<td>".$row['RemainingStock']."</td>";

          echo "</tr>";

          $counter ++;

        }

      }

    }


    public function sync_created_product(){

      include("../connection.php");
      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sql = "SELECT * FROM tbl_createdat WHERE tableName = 'tblproduct'
                AND createdStatus = 1 ORDER BY createdID ASC";

        $result = $con->query($sql);

        if($result->num_rows > 0){

          while($row = $result->fetch_assoc()){

            $hold_value = explode("=",$row['fieldValue']);

            $sql_sync = $con_online->prepare("INSERT INTO tblproduct (productID,productName,productCategory,productUnit,
                                              productQntyPerUnit,productPricePerUnit,productCompany,productPhoto,
                                              productAlertStatus,productAlertQuantity) VALUES (?,?,?,?,?,?,?,?,?,?)");

            $sql_sync->bind_param("ssssddssii",$hold_value[0],$hold_value[1],$hold_value[2],$hold_value[3],
                                   $hold_value[4],$hold_value[5],$hold_value[6],$hold_value[7],
                                   $hold_value[8],$hold_value[9]);

            if($sql_sync->execute() == TRUE){

              $this->update_sync_status($row['createdID'],"tbl_createdat","createdStatus","createdID");

            }

          }

        }

      }

    }

    public function sync_updated_product(){

      include("../connection.php");
      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sql = "SELECT * FROM tbl_updatedat WHERE tableName = 'tblproduct'
                AND updatedStatus = 1 ORDER BY updateID ASC";

        $result = $con->query($sql);

        if($result->num_rows > 0){

          while($row = $result->fetch_assoc()){

            $check = "";

            $hold_value = explode("=",$row['fieldValue']);

            $sql_sync = $con_online->prepare("UPDATE tblproduct SET productName = ?, productCategory = ?,
                                              productUnit = ?, productQntyPerUnit = ?, productPricePerUnit = ?,
                                              productCompany = ?, productPhoto = CASE WHEN ? LIKE '$check'
                                              THEN productPhoto ELSE ? END, productAlertStatus = ?, productAlertQuantity = ?
                                               WHERE productID = ?");

            $sql_sync->bind_param("sssddsssiis",$hold_value[1],$hold_value[2],$hold_value[3],$hold_value[4],
                               $hold_value[5],$hold_value[6],$hold_value[7],$hold_value[7],
                               $hold_value[8],$hold_value[9],$hold_value[0]);

            if($sql_sync->execute() == TRUE){

              $this->update_sync_status($row['updateID'],"tbl_updatedat","updatedStatus","updateID");

            }

          }

        }

      }

    }

    public function sync_deleted_product(){

      include("../connection.php");
      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sql = "SELECT * FROM tbl_deletedat WHERE tableName = 'tblproduct'
                AND deletedStatus = 1 ORDER BY deletedID ASC";

        $result = $con->query($sql);

        if($result->num_rows > 0){

          while($row = $result->fetch_assoc()){

            $status = 0;

            $sql_sync = $con_online->prepare("UPDATE tblproduct SET productStatus = ?
                                              WHERE productID = ?");

            $sql_sync->bind_param("ss",$status,$row['fieldValue']);

            if($sql_sync->execute() == TRUE){

              $this->update_sync_status($row['deletedID'],"tbl_deletedat","deletedStatus","deletedID");

            }

          }

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
