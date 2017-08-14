<div class="modal-header">
  <h3 class="hd-font-h3-3">Add Fee</h3>
</div>

<div class="content">

  <form class="ui form" id="addfeeform" onsubmit="return false">

    <div class="container-fluid">

        <div class="two fields">

          <div class="field">
            <label>Fee Name<label>
            <input type="text" placeholder="Fee Name" name="fee_name" id="fee_name">
          </div>

          <div class="field">
            <label>Fee Amount<label>
            <input type="text" placeholder="Fee Amount" name="fee_amnt" id="fee_amnt">
          </div>

        </div>

    </div>

  </form>

</div>

<div class="right actions">

  <input class="ui pink button" type="submit"
          name="done" value="Add" onclick="addNewFee()">

  <input class="ui cancel pink button"  type="submit"
          name="done" value="Close">

</div>
