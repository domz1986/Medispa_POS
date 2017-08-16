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


    public function loadProductListToCards($srch){

      $search_value = $this->clean_value($srch);

      include("../connection.php");

      $sql = "SELECT productQntyPerUnit,productCategory,productPhoto,productName,productPricePerUnit,
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
          echo '<input class="mini ui gray button invent1" type="submit" name="submit"
                value="Add Transaction" onclick="addCurrenttable(\''.$row['ID'].'\',\''.
                $row['productName'].'\','.$qnty.',\''.$row['productPhoto'].'\',\''.
                $row['productCategory'].'\','.$row['productPricePerUnit'].',\''.
                $row['productUnit'].'\','.$row['productQntyPerUnit'].')"></i>';
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
    public function loadstocks()
    {
      include("../connection.php");

      $sql = "SELECT * FROM tblproductstocks WHERE stockStatus LIKE 1 AND stockQntyRemaining > 0 AND productID = '".$this->productID."' ORDER BY stockExpiration ASC";

      $result = $con->query($sql);
      //echo $sql;
      if($result->num_rows > 0)
      {
        $checkid=0;
        while($row = $result->fetch_assoc())
        {
          echo "<tr>";
          echo "<td><input type='checkbox' value='".$row['stockID']."' id='check".$checkid."' style='display:block'></td>";
          echo "<td>".$row['stockExpiration']."</td>";
          echo "<td>".$row['stockQntyRemaining']."</td></tr>";
          $checkid++;
        }
      }

    }
    private function clean_value($value){

      $return_value = preg_replace('/[^a-zA-Z0-9\s-_\/().%+&#]/', "", strip_tags($value));

      return $return_value;

    }

  }

 ?>
