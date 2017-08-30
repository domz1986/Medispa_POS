<div class="modal-header">
  <h3 class="hd-font-h3-3">Add Discount</h3>
</div>

<div class="content">

  <form class="ui form" id="adddiscountform" onsubmit="return false">
    <div class="ui top attached segment d-1">
      <div class="container-fluid">

          <div class="two fields">


            <div class="field">
              <label>Discounted Amount</label>
              <input type="text" placeholder="discounted Amount" name="discounted_amnt" id="discounted_amnt">
            </div>

          </div>

      </div>
    </div>
  </form>

</div>

<div class="right actions">

  <input class="ui pink button" type="submit"
          name="done" value="Add" onclick="addDiscount()">

  <input class="ui cancel pink button"  type="submit"
          name="done" value="Close">

</div>
<script src="../Modal/Modalscript/addDiscount_modalscript.js"></script>
