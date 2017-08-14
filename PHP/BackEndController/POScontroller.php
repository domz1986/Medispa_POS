<?php

  session_start();

  include("../Class/inventoryclass.php");
  include("../Class/inventorystockclass.php");

  switch ($_POST['func']) {

    case 1: //LOAD STOCKS TO CARDS

      $loadproducttocards = new InventoryClass();
      echo $loadproducttocards->loadProductListToCards($_POST['srch']);
      break;

    case 5: //GET ALL PRODUCT NAME

      $getproductlist = new InventoryClass();
      $list = $getproductlist->getAllProductName();
      echo json_encode($list);
      break;

    case 6: //SET PRODUCT ID SESSION

      $_SESSION['updateProductID'] = $_POST['id'];
      echo $_SESSION['updateProductID'];

      break;

    case 7: //GET PRODUCT INFO FOR UDPATE

      $getproductinfo = new InventoryClass();
      $getproductinfo->setProductID($_SESSION['updateProductID']);
      echo $getproductinfo->getProductInfo();
      break;

    case 8: //UPDATE PRODUCT INFO

      $updateProduct = new InventoryClass();

      if(isset($_FILES['up_photo']["name"]) && !empty($_FILES['up_photo']["name"])){

        $file_name = basename($_FILES["up_photo"]["name"]);
        $target_dir = "../../UploadedProductPhoto/";
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["up_photo"]["tmp_name"], $target_file)){

          $updateProduct->setProductName($_POST['up_name']);
          $updateProduct->setProductCategory($_POST['up_category']);
          $updateProduct->setProductUnit($_POST['up_unit']);
          $updateProduct->setProductQntyPerUnit($_POST['up_qntyperunit']);
          $updateProduct->setProductPricePerUnit($_POST['up_priceperunit']);
          $updateProduct->setProductCompany($_POST['up_company']);
          $updateProduct->setProductPhoto($file_name);
          $updateProduct->setAlertType($_POST['up_alerttype']);
          $updateProduct->setAlertQuantity($_POST['up_alertquantity']);

          $updateProduct->setProductID($_SESSION['updateProductID']);

          echo $updateProduct->updateProductInfo();

        }else {

          echo 0;

        }

      }

      else{

        $updateProduct->setProductName($_POST['up_name']);
        $updateProduct->setProductCategory($_POST['up_category']);
        $updateProduct->setProductUnit($_POST['up_unit']);
        $updateProduct->setProductQntyPerUnit($_POST['up_qntyperunit']);
        $updateProduct->setProductPricePerUnit($_POST['up_priceperunit']);
        $updateProduct->setProductCompany($_POST['up_company']);
        $updateProduct->setProductPhoto("");
        $updateProduct->setAlertType($_POST['up_alerttype']);
        $updateProduct->setAlertQuantity($_POST['up_alertquantity']);

        $updateProduct->setProductID($_SESSION['updateProductID']);

        echo $updateProduct->updateProductInfo();

      }

      break;

    case 9: //LOAD STOCKS TO TABLE

      $loadstockstotable = new InventoryStockClass();
      $loadstockstotable->setProductID($_SESSION['updateProductID']);
      echo $loadstockstotable->loadStocksToTable();
      break;

    case 10: //UPDATE STOCKS

      $updatestock = new InventoryStockClass();
      $updatestock->setStockID($_POST['id']);
      $updatestock->setQntyStockIn($_POST['sqs']);
      $updatestock->setStockQntyRemaining($_POST['sqr']);
      $updatestock->setExpirationDate($_POST['sde']);
      echo $updatestock->UpdateStockInformation();
      break;

    case 11: //DELETE PRODUCT

      $deleteproduct = new InventoryClass();
      $deleteproduct->setProductID($_POST["id"]);
      echo $deleteproduct->deleteProduct();
      break;

    case 12: //LOAD STOCK HISTORY TO TokyoTyrantTable

      $loadstockhistorytotable = new InventoryStockClass();
      $loadstockhistorytotable->setProductID($_SESSION['updateProductID']);
      echo $loadstockhistorytotable->loadStockHistory($_POST['ds'],$_POST['de']);
      break;

    case 13: //LOAD PRODUCTS TO PRINT

      $loadproductstoprint = new InventoryClass();
      echo $loadproductstoprint->loadProductsToPrint();
      break;

    case 14: //LOAD LOW ON showLowStocks

      $loadlowstocks = new InventoryClass();
      echo $loadlowstocks->loadProductLowOnStocks();
      break;

  }

 ?>
