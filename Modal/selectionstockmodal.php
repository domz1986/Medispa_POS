<div class="modal-header">
  <h3 class="hd-font-h3-3">Add Fee</h3>
</div>

<div class="content">

  <form class="ui form" id="selectstock" onsubmit="return false">
    <div id='Qnty' style="display:none"></div>
    <div id='Price' style="display:none"></div>
    <div class="ui fluid container">
      <div class="ui top attached segment d-1">
  <div id="table-wrapper">
      <div id="table-scroll">
          <table class="ui celled table">
            <thead>
              <tr><th>Product Name</th>
              <th>Category</th>
              <th>Expiration Date</th>
              <th>Remaining Quantity</th>
              </tr>
            </thead>
            <tbody id="tbl_body">
            </tbody>
          </table>
    </div>
  </div>
</div>
</div>

  </form>

</div>

<div class="right actions">

  <input class="ui pink button" type="submit"
          name="done" value="Add" onclick="">

  <input class="ui cancel pink button"  type="submit"
          name="done" value="Close">

</div>
<script src="../Modal/Modalscript/selectionstock_modalscript.js"></script>
