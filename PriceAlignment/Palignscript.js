  window.onload = loadDataOnload();


  function loadDataOnload()
  {
    re_align();
  //$('#result').html("done.");


  }

function re_align()
{
  $.ajax({
      url: "../PHP/BackEndController/tempcontroller.php",
      type: "POST",
      data: {func: 1},
      async: false,
      success: function(resultdata)
      {
        alert(resultdata);
        $('#result').html(resultdata);
      }
    });
}
