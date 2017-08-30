window.onload = loadDefaultOnload();

$(".transactionDropDown").dropdown();

function loadDefaultOnload(){


}
function addDiscount()
{

  var ptable = document.getElementById('tbl_body');
  var pamnt = document.getElementById('discounted_amnt');
  var row = ptable.insertRow(ptable.rows.length);

  var x = row.insertCell();
  x.setAttribute("style","display:none");
  x.innerHTML="discount";

  var y = row.insertCell();
  y.setAttribute("style","display:none");
  y.innerHTML=parseFloat(pamnt.value).toFixed(2);

  var z = row.insertCell();
  z.innerHTML="Discount";
  z.setAttribute("style","cursor:pointer;");
  z.setAttribute("onclick","remove_row('"+x.innerHTML+"','"+y.innerHTML+"')");

  row.insertCell().innerHTML="";
  row.insertCell().innerHTML=parseFloat(pamnt.value).toFixed(2);
  total_update();
  $('#addDiscountModal').modal('hide');
}
