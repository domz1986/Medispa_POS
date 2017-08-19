<html>
  <head>
      <center>
        <title>Transaction Receipt</title>

        <link href="../Libraries/semantic/semantic.min.css" rel="stylesheet" type="text/css">
        <link href="../Libraries/semantic/semantic.css" rel="stylesheet" type="text/css">
        <link href="../Libraries/main.css" rel="stylesheet" type="text/css">

        <script src="../Libraries/jquery-1.12.4.js" type="text/javascript"></script>
        <script src="../Libraries/ajax-3.1.1.js" type="text/javascript"></script>


        <script src="../Libraries/semantic/semantic.js"></script>
        <script src="../Libraries/semantic/semantic.min.js"></script>

    </center>
  </head>
  <body>
    <div class="page-wrapper">
      <div class="main">

        <div class="outer-admin">

          <div class="wrapper-admin">

            <div class="content-admin"> <!-- PAGE CONTENT -->

              <div class="content-admin-wrapper">

        <center>
          <div class="header-statusbar">
            <div class="header-statusbar-inner">
                <div class="ui fluid container">

                  <div class='row'>
                    <h2 align="center">MediSpa</23>
                  </div>
                  <div class='row'>
                    <label>Dermatology and Wellness</label>
                  </div>
                  <br>
                  <div class='row'>
                    <div class='column'>
                      <label>Purchase Receipt as of: </label>
                      <b><label id='dateandtime'> </label></b>
                    </div>
                  </div>

                <div class="ui top attached segment d-1">
                  <div id="table-wrapper">
                      <div id="table-scroll">
                          <table class="ui celled table" id='r_table'>
                          <thead>
                            <tr>
                              <th>Product Name</th>
                              <th>Quantity</th>
                              <th>Price</th>
                            </tr>
                          </thead>
                          <tbody id='r_tbody'>
                          </tbody>
                        </table>
                      </div>
                    </div>

                      <div class="ui top attached segment d-1">
                        <div class="three fields">
                          <div class="field">
                            <div style="display:block; margin-left:300px;">Total: <b> <h7 id="totalvalue" style="padding-left:3em"></h7></b></div>
                          </div>
                        </div>
                      </div>
                      <br>
                      <label><i>Thank you and Have a great day!</i><label>

                </div>
              </div>
            </div>
          </div>
        </center>
      </div>
    </div>
  </div>
</div>
</div>
      </div>
      <script src="../Print/transcript.js" type="text/javascript"></script>
      <script  type="text/javascript">
          $(document).ready(function(){
              var a = sessionStorage.getItem("senta");
              var b = sessionStorage.getItem("total");
              var c = sessionStorage.getItem("datetime");
              $('#r_tbody').html(a);
              $('#totalvalue').html(b);
              $('#dateandtime').html(c);
          });
      </script>
  </body>
</html>
