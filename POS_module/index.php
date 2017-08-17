<?php

session_start();

?>

<!DOCTYPE html>
<html>

  <head>

    <title>Inventory</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">


    <link href="../Libraries/font-awesome/font/font.css" rel="stylesheet" type="text/css">
    <link href="../Libraries/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../Libraries/owl.carousel/assets/owl.carousel.css" rel="stylesheet" type="text/css" >
    <link href="../Libraries/colorbox/example1/colorbox.css" rel="stylesheet" type="text/css" >
    <link href="../Libraries/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="../Libraries/bootstrap-fileinput/fileinput.min.css" rel="stylesheet" type="text/css">
    <link href="../Libraries/superlist.css" rel="stylesheet" type="text/css">

    <link rel = "stylesheet" type = "text/css" href="../Libraries/semantic/semantic.css">

    <script src="../Libraries/ajax-3.1.1.js"></script>
    <script src="../Libraries/jquery-1.10.2.js"></script>

    <script src="../Libraries/semantic/semantic.js"></script>
    <script src="../Libraries/semantic/semantic.min.js"></script>

  </head>

  <body>

    <div class="page-wrapper">

      <header class="header header-minimal"> <!-- HEADER -->
        <div class="header-statusbar">
          <div class="header-statusbar-inner">

            <div class="header-statusbar-left"> <!-- MEDISPA -->
              <span class="hd-font-h1">MEDIspa</span>
            </div>

            <div class="header-statusbar-right"> <!-- SYNC/LOGOUT -->
              <div class="hidden-xs visible-lg">
                <ul class="breadcrumb">
                  <li><a href="#" class="hd-font-h1-1">Logout</a></li>
                </ul>
              </div>
            </div>

          </div>
        </div>
      </header>

      <div class="main">

        <div class="outer-admin">

          <div class="wrapper-admin">

            <div class="content-admin"> <!-- PAGE CONTENT -->

              <div class="content-admin-wrapper">

        <div class="ui fluid container">
          <div class="ui top attached segment d-1">
            <div class="ui form">
              <div class="two fields">

                <div class="field">
                      <div class="container-fluid"> <!-- INVENTORY CONTENT -->

                        <div class="row"> <!-- PRODUCT LIST -->


                              <div class="ui top attached segment d-1">
                                  <h4><b>Product List</b></h4>
                                  <label>Search</label>
                                  <div class="two fields">
                                      <div class="field">
                                        <div class="ui fluid category search">
                                            <input placeholder="Search Stocks" id="srchproductname">
                                        </div>
                                      </div>
                                      <div class="right field">
                                          <input class="mini ui pink button" type="submit" name="submit" value="Add Additional Fees" onclick="addFeetotable()">
                                      </div>
                                  </div>
                            </div>

                        </div>
                        <br>
                        <div class="row"> <!-- LIST PRODUCT TO CARDS -->
                          <div class="ui top attached segment d-1">
                            <div id="table-wrapper">
                              <div id="table-scroll">
                                  <div id="loadproductcards">
                                    <!-- LIST OF ALL PRODUCTS -->
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>

                    </div>
                </div>
                <div class="field">
                    <div class="ui top attached segment d-1">
                      <h4><b>Current Transaction</b></h4>
                      <div id="table-wrapper">
                          <div id="table-scroll">
                            <table class="ui celled table" id='tbl_purchase'>
                              <thead>
                                <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                </tr>
                              </thead>
                              <tbody id="tbl_body">
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>
                      <div class="ui top attached segment d-1">
                        <div class="two fields">
                          <div class="field">
                            <div align="right"><b>Total:</b></div>
                          </div>
                          <div class="field">
                            <div align="center"><b>0.00</b></div>
                          </div>
                        </div>
                        <div class="header-statusbar">
                          <div class="header-statusbar-inner">
                            <div class="two fields">
                              <div class="field left">
                                  <input class="mini ui gray button invent1" type="submit" name="submit" value="Clear All" onclick="clearall()">
                              </div>
                              <div class="field right">
                                <input class="mini ui gray button invent1" type="submit" name="submit" value="Save">
                                <input class="mini ui gray button invent1" type="submit" name="submit" value="Save and Print">
                              </div>
                          </div>
                        </div>
                      </div>

                </div> <!--field-->

              </div>
            </div>
          </div> <!-- FOOTER -->
          <br>
            <div class="container-fluid">
                  &copy; 2017 All rights reserved. Created by <a class="footerer" href='https://www.desdevconcept.com'> Desdev Concept </a>
            </div>
          <br>
        </div> <!--fluid container-->

      </div>
    </div>
  </div>

  </div>

</div>
</div>

    <div> <!-- ADD NEW PRODUCT MODAL -->
      <div class="ui small modal addproduct" id="addtransactionModal" style="height: 420px;">
      </div>
    </div>

    <div> <!-- ADD NEW PRODUCT MODAL -->
      <div class="ui small modal addproduct" id="addfeeModal" style="height: 265px;">
      </div>
    </div>


    <script src="../FrontEndController/posscript.js"></script>

  </body>

</html>
