<?php

  session_start();

  include("../Class/inventoryclass.php");
  include("../Class/inventorystockclass.php");
  include("../Class/transactionclass.php");

  switch ($_POST["func"]) {

    case 1:

      include("../connection_online.php");

      if ($con_online->connect_error == FALSE) {

        $sync_data_inventory = new InventoryClass();
        $sync_data_inventory->sync_created_product();
        $sync_data_inventory->sync_updated_product();
        $sync_data_inventory->sync_deleted_product();

        $sync_data_inventorystocks = new InventoryStockClass();
        $sync_data_inventorystocks->sync_created_stocks();
        $sync_data_inventorystocks->sync_updated_stocks();


        $sync_data_transaction = new TransactionClass();
        $sync_data_transaction->sync_created_sales();
        $sync_data_transaction->sync_created_salesproduct();
        $sync_data_transaction->sync_created_salesfees();

        update_datetime();
        echo 1;

      }
      else {

        echo 2;

      }

      break;

    case 2:

      $sync_data_transaction = new TransactionClass();
      echo $sync_data_transaction->getLastSyncDateTime();
      break;

  }

  function update_datetime(){

    include("../connection.php");
    include("../connection_online.php");

    $date_time = date("Y-m-d H:i:s");
    $sql = "UPDATE tbl_webdata SET lastdatetimesync = '$date_time' WHERE webdataID = 1";

    $con_online->query($sql);
    $con->query($sql);

  }

 ?>
