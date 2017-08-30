<?php

  class TempClass{


    public function realign()
    {
      include("../connection.php");

      $sql = "SELECT salesID FROM tblsales WHERE salesStatus LIKE 1";
      $result = $con->query($sql);

      if($result->num_rows > 0)
      {
        while($row = $result->fetch_assoc())
        {
          $sql_2 = "SELECT SUM((SELECT COALESCE(SUM(sfeeAmnt),0) FROM tblsalesfees WHERE salesID = '".$row['salesID']."')+(SELECT COALESCE(SUM(spAmnt),0) FROM tblsalesproduct WHERE salesID = '".$row['salesID']."')) as sumall";
          $result2 = $con->query($sql_2);
          if($result2->num_rows > 0)
          {
            while($row2 = $result2->fetch_assoc())
            {
              echo $row['salesID']." = ".$row2['sumall'];
              $sql_3 = $con->prepare("UPDATE tblsales SET salesTotalPrice = ".$row2['sumall']." WHERE salesID = '".$row['salesID']."'");
              //echo $sql_3;
              if($sql_3->execute() == TRUE)
              {
                echo "-(success)";
              }
              else
              {

                  return "Statement failed: ". $sql_3->error . " <br> ".$con->error;
              }
              echo "<br>";
            }
          }
        }
      }
    }


  }

 ?>
