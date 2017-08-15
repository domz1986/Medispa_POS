<div class="modal-header">
  <h3 class="hd-font-h3-3">Include to Purchase</h3>
</div>

<div class="content">

    <form class="ui form" id="addproductform" onsubmit="return false" enctype="multipart/form-data">

          <div class="ui top attached segment d-1">
            <div class="three fields">
                <div class="field">
                  <div class="two fields">
                    <div class="field">
                      <div class="card-small-image">
                      <img id="picture" src="" alt='Error'>
                      </div>
                    </div>
                    <div class="field">
                      <div class="t-left">
                          <h6>Name:</h6>
                          <h6>Category:</h6>
                          <h6>Price per Unit:</h6>
                          <h6>Content:</h6>
                          <h6>Total Quantity:</h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div class="t-left">
                    <h6 id='proname'></h6>
                    <h6 id='procat'></h6>
                    <h6 id='proprice'></h6>
                    <h6 id='procon'></h6>
                    <h6 id='proqnty'></h6>
                  </div>
                </div>
                <div class="field">

                    <table class="ui definition table">
                      <thead>
                        <tr><th></th>
                        <th>Quantity</th>
                        <th>Price</th>
                        </tr>
                      </thead>
                      <tbody id="tbl_body">
                      </tbody>
                    </table>
                </div>
          </div>
          <div class="row">
            <div class="container-fluid">
              <div class="two fields">
                <div class="field">
                  <label>Transaction Type</label>
                  <div class="ui fluid selection dropdown transactionDropDown" id="tran_type">
                    <input type="hidden" name="tran_type2" onchange="check_type()">
                    <i class="dropdown icon"></i>
                    <div class="default text">Select Type</div>
                    <div class="menu">
                      <div class='item' data-value="1">Sold Individually</div>
                      <div class='item' data-value="0">Sold by Repack</div>
                    </div>
                  </div>
                </div>
                <div class="field">
                  <div  class="row col-sm-5" id="indi" style="display:none">
                      <label>Set Price</label>
                      <input type="text" id="Individual_price">
                  </div>
                  <div  class="row col-sm-5" id="repack" style="display:none">
                      <label>Quantity</label>
                      <input type="text" id="Repack_quantity">
                  </div>
                </div>

            </div>
          </div>
      </div>
      <div class="right actions">

        <input class="ui pink button" type="submit"
                name="done" value="Save" onclick="check_request()">

        <input class="ui cancel pink button"  type="submit"
                name="done" value="Close">

      </div>
    </form>

</div>


<script src="../Modal/Modalscript/addtransaction_modalscript.js"></script>
