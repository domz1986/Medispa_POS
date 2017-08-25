<?php

  date_default_timezone_set('Asia/Singapore');

  class InventoryClass{

    //sales
    private $salesID;
    private $salesTotalPrice;
    private $salesDate;
    private $salesType;
    private $patientID;
    private $salesStatus;

    //fees
    private $sfeeID;
    private $sfeeName;
    private $sfeeAmnt;
    private $sfeeStatus;

    //product STOCKS
    private $stockID;
    private $stockQntyRemaining;

    //product
    private $salesProductID;
    private $spQnty;
    private $spAmnt;
    private $spStatus;

    //inventory
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



    public function setsalesID($salesid)
    {
      $this->salesID = $salesid;
    }
    public function setsalesTotalPrice($salestotalprice)
    {
      $this->salesTotalPrice = $salestotalprice;
    }
    public function setsalesDate($salesdate)
    {
      $this->salesDate = $salesdate;
    }
    public function setsalesStatus($salesstatus)
    {
      $this->salesStatus = $salesstatus;
    }



    public function setsfeeID($sfeeid)
    {
      $this->sfeeID = $sfeeid;
    }
    public function setsfeeName($sfeename)
    {
      $this->sfeeName = $sfeename;
    }
    public function setsfeeAmnt($sfeeamnt)
    {
      $this->sfeeAmnt = $sfeeamnt;
    }

    public function setsalesProductID($salesproductid)
    {
      $this->salesProductID = $salesproductid;
    }
    public function setspQnty($spqnty)
    {
      $this->spQnty = $spqnty;
    }
    public function setspAmnt($spamnt)
    {
      $this->spAmnt = $spamnt;
    }
    public function setspStatus($spstatus)
    {
      $this->spStatus = $spstatus;
    }


    public function setstockID($stock_id)
    {
      $this->stockID = $this->clean_value($stock_id);
    }
    public function setstockQntyRemaining($stockqntyremaining)
    {
      $this->stockQntyRemaining = $stockqntyremaining;
    }



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

            $qnty = $row['Qnty']*$row['productQntyPerUnit'];

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
          echo '<h5 style="cursor:pointer;" >'
                                        .$row['productName'].'</h5>';
          echo '<h4>Quantity: <h7 id="stockq'.$row['ID'].'">'.$qnty.'</h7></h4>';
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
        $sql2 = "SELECT productQntyPerUnit from tblproduct where productID = '".$this->productID."'";
        $result2 = $con->query($sql2);
        while($row2 = $result2->fetch_assoc())
        {
            $checkid=0;
            while($row = $result->fetch_assoc())
            {
              echo "<tr>";
              echo "<td><input type='checkbox' value='".$row['stockID']."' id='check".$checkid."' style='display:block'></td>";
              echo "<td>".$row['stockExpiration']."</td>";
              echo "<td>".$row['stockQntyRemaining']*$row2['productQntyPerUnit']."</td></tr>";
              $checkid++;
            }
        }
      }

    }
    private function clean_value($value){

      $return_value = preg_replace('/[^a-zA-Z0-9\s-_\/().%+&#]/', "", strip_tags($value));

      return $return_value;

    }
    public function savesales()
    {
      include("../connection.php");
      $this->generateID("sales");
      $sql = $con->prepare("INSERT INTO tblsales (salesID,salesTotalPrice,salesDate,salesType,patientID,salesStatus) VALUES ('".$this->salesID."',".$this->salesTotalPrice.",'".$this->salesDate."',1,1,1)");

      if($sql->execute() == TRUE)
      {
        return $this->salesID;
      }
      else
      {
          return "Statement failed: ". $sql->error . " <br> ".$con->error;
      }
    }
    public function savefees()
    {
      include("../connection.php");
      $this->generateID("fees");
      $sql = $con->prepare("INSERT INTO tblsalesfees (sfeeID,sfeeName,sfeeAmnt,salesID,sfeeStatus) VALUES ('".$this->sfeeID."','".$this->sfeeName."',".$this->sfeeAmnt.",'".$this->salesID."',1)");

      if($sql->execute() == TRUE)
      {
        return 1;
      }
      else
      {
          return "Statement failed: ". $sql->error . " <br> ".$con->error;
      }
    }
    public function saveproduct()
    {
      include("../connection.php");
      $this->generateID("product");
      $sql = $con->prepare("INSERT INTO tblsalesproduct (salesProductID,salesID,productID,spQnty,spAmnt,spStatus) VALUES ('".$this->salesProductID."','".$this->salesID."','".$this->productID."',".$this->spQnty.",".$this->spAmnt.",1)");

      if($sql->execute() == TRUE)
      {
        return 1;
      }
      else
      {
          return "Statement failed: ". $sql->error . " <br> ".$con->error;
      }
    }
    public function reducestockqnty()
    {
      include("../connection.php");

      $sql = "SELECT stockQntyRemaining FROM tblproductstocks WHERE stockStatus LIKE 1 AND stockQntyRemaining > 0 AND stockID = '".$this->stockID."'";

      $result = $con->query($sql);
      $stockqnty = 0;
      if($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $stockqnty=$row['stockQntyRemaining'];
        }
      }


      if($this->spQnty<=$stockqnty)
      {
        $sql2 = $con->prepare("UPDATE tblproductstocks SET stockQntyRemaining=$stockqnty-$this->spQnty WHERE stockID = '".$this->stockID."'");

        if($sql2->execute() == TRUE)
        {
          return true;
        }
        else
        {
            return "Statement failed: ". $sql2->error . " <br> ".$con->error;
        }
      }
      else
      {
        $sql2 = $con->prepare("UPDATE tblproductstocks SET stockQntyRemaining=0 WHERE stockID = '".$this->stockID."'");
        $remainder = $stockqnty-$this->spQnty;
        if($sql2->execute() == TRUE)
        {
          return $remainder;
        }
      }
    }
    public function generateID($type)
    {
      include("../connection.php");
      if($type=="sales")
      {
        $sql = "SELECT salesID FROM tblsales ORDER BY salesID DESC LIMIT 1";

        $result = $con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $hold = explode("-",$row['salesID']);
                $id = $hold[1]+1;
                $this->salesID = "TR-".$id;
            }
            //echo "enter = {".$this->salesID."} ";
        }
        else
        {
            $this->salesID = "TR-10000";

        }

      }
      else if($type=="fees")
      {
        $sql = "SELECT sfeeID FROM tblsalesfees ORDER BY sfeeID DESC LIMIT 1";

        $result = $con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $hold = explode("-",$row['sfeeID']);
                $id = $hold[1]+1;
                $this->sfeeID = "offline_SF-".$id;
            }
        }
        else
        {
            $this->sfeeID = "offline_SF-10000";

        }

      }
      else if($type=="product")
      {
        $sql = "SELECT salesProductID FROM tblsalesproduct ORDER BY salesProductID DESC LIMIT 1";

        $result = $con->query($sql);
        if($result->num_rows > 0)
        {
            while($row = $result->fetch_assoc())
            {
                $hold = explode("-",$row['salesProductID']);
                $id = $hold[1]+1;
                $this->salesProductID = "offline_SP-".$id;
            }
        }
        else
        {
            $this->sfeeID = "offline_SP-10000";

        }

      }
    }

  }

 ?>
